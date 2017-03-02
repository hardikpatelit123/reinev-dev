<?php

/*
* function to override total spend
*
*/
if (!function_exists('fre_display_user_info')) {

    /**
     * display user info of a freelancer or employser
     * @param  int $profile_id
     * @return display info in single-project.php or author.php
     */
    function fre_display_user_info($user_id) {

        global $wp_query, $user_ID;

        $user = get_userdata($user_id);
        $ae_users = AE_Users::get_instance();
        $user_data = $ae_users->convert($user);
        $role = ae_user_role($user_id);
        if( !fre_share_role()){
?>
        <div class="info-company-avatar">
            <a href="<?php echo get_author_posts_url($user_id); ?>">
                <span class="info-avatar"><?php echo get_avatar($user_id, 35); echo get_the_title($user_id); ?></span>
            </a>
            <div class="info-company">
                <h3 class="info-company-name"><?php echo $user_data->display_name; ?></h3>
                <span class="time-since">
                    <?php printf(__('Member Since %s', ET_DOMAIN) , date_i18n(get_option('date_format') , strtotime($user_data->user_registered))); ?>
                </span>
            </div>
        </div>
        <?php } //end if share roles ?>
        <ul class="list-info-company-details">
        <?php
        if ($role == 'freelancer') {
?>
                <li>
                    <div class="address">
                        <span class="addr-wrap">
                            <span class="title-name"><i class="fa fa-map-marker"></i><?php _e('Address:', ET_DOMAIN); ?></span>
                            <span class="info addr" title="<?php echo $user_data->location; ?>">
                            <?php echo $user_data->location; ?>
                            </span>
                        </span>
                    </div>
                </li>
                <li>
                    <div class="spent"><i class="fa fa-money"></i>
                        <?php _e('Earning:', ET_DOMAIN); ?>
                        <span class="info">
                            <?php echo fre_price_format(fre_count_meta_value_by_user($user_id, 'bid', 'bid_budget')); ?>
                        </span>
                    </div>
                </li>
                <li>
                    <div class="briefcase"><i class="fa fa-briefcase"></i>
                        <?php _e('Project complete:', ET_DOMAIN); ?>
                        <span class="info">
                            <?php echo fre_count_user_posts_by_type($user_id, BID, 'complete'); ?>
                        </span>
                    </div>
                </li>
                <?php
        } else { ?>
                <li>
                    <div class="address">
                    <span class="addr-wrap">
                        <span class="title-name"><i class="fa fa-map-marker"></i><?php _e('Address:', ET_DOMAIN); ?></span>
                        <span class="info addr" title="<?php echo $user_data->location; ?>">
                            <?php echo $user_data->location; ?>
                        </span>
                        </span>
                    </div>
                </li>
                <li>
                    <div class="spent"><i class="fa fa-globe"></i>
                        <?php _e('Website:', ET_DOMAIN); 
                        if($user_data->et_website_url != ''){ ?>
                            <span class="info"><a href="<?php echo $user_data->et_website_url; ?>" target="_blank"><?php echo preg_replace('#^https?://#', '', $user_data->et_website_url); ?></a></span>
                        
                        <?php }else{ ?>

                             <span class="info">N/A</span>
                        <?php } ?>
                    </div>
                </li>
                <li>
                    <div class="briefcase"><i class="fa fa-briefcase"></i>
                        <?php _e('Project posted:', ET_DOMAIN); ?>
                        <span class="info"><?php echo fre_count_user_posts_by_type($user_id, 'project', '"publish","complete","close" ', true); ?></span>

                    </div>
                </li>
                <li>
                    <div class="hired"><i class="fa fa-send"></i>
                        <?php _e('Hires:', ET_DOMAIN); ?>
                        <span class="info"><?php echo fre_count_user_posts_by_type($user_id, 'project', 'complete'); ?></span>
                    </div>
                </li>
                <?php
        }
?>
        </ul>
        <?php
        do_action('fre_after_block_user_info', $user_id);
    }
}