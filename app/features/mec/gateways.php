<?php
/** no direct access **/
defined('MECEXEC') or die();

$gateways = $this->main->get_gateways();
?>

<div class="wns-be-container">

    <div class="wns-be-sidebar">

        <ul class="wns-be-group-menu">

            <li class="wns-be-group-menu-li has-sub">
                <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" id="" class="wns-be-group-tab-link-a">
                    <span class="extra-icon">
                        <i class="sl-arrow-down"></i>
                    </span>
                    <i class="mec-sl-settings"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Settings', 'mec'); ?></span>
                </a>
            </li>

            <?php if($this->main->getPRO() and isset($this->settings['booking_status']) and $this->settings['booking_status']): ?>

                <li class="wns-be-group-menu-li">
                    <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-reg-form'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-layers"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Booking Form', 'mec'); ?></span>
                    </a>
                </li>            

                <li class="wns-be-group-menu-li active">
                    <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-gateways'); ?>" id="" class="wns-be-group-tab-link-a">
                        <i class="mec-sl-wallet"></i> 
                        <span class="wns-be-group-menu-title"><?php _e('Payment Gateways', 'mec'); ?></span>
                    </a>
                </li>

            <?php endif;?>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-notifications'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-envelope"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Notifications', 'mec'); ?></span>
                </a>
            </li> 

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-styling'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-equalizer"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Styling Options', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-customcss'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-wrench"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Custom CSS', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-messages'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-bubble"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Messages', 'mec'); ?></span>
                </a>
            </li>

            <li class="wns-be-group-menu-li">
                <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-support'); ?>" id="" class="wns-be-group-tab-link-a">
                    <i class="mec-sl-support"></i> 
                    <span class="wns-be-group-menu-title"><?php _e('Support', 'mec'); ?></span>
                </a>
            </li>

        </ul>
    </div>

    <div class="wns-be-main">

        <div id="wns-be-infobar">
            <a href="" id="" class="dpr-btn dpr-save-btn">Save Changes</a>
        </div>

        <div id="wns-be-notification"></div>

        <div id="wns-be-content">
            <div class="wns-be-group-tab">
                <h2><?php _e('Payment Gateways', 'mec'); ?></h2>
                <div class="mec-container">
                    <form id="mec_gateways_form">
                        <div class="mec-form-row" id="mec_gateways_form_container">
                            <ul>
                                <?php foreach($gateways as $gateway): ?>
                                    <li id="mec_gateway_id<?php echo $gateway->id(); ?>">
                                        <?php $gateway->options_form(); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="mec-form-row">
                            <?php wp_nonce_field('mec_options_form'); ?>
                            <button   style="display: none;" id="mec_gateways_form_button" class="button button-primary mec-button-primary" type="submit"><?php _e('Save Changes', 'mec'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="wns-be-footer">
            <a href="" id="" class="dpr-btn dpr-save-btn">Save Changes</a>
        </div>
    </div>

</div>

<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery(".dpr-save-btn").on('click', function(event) {
            event.preventDefault();
        jQuery("#mec_gateways_form_button").trigger('click');
    });
});
jQuery("#mec_gateways_form").on('submit', function(event)
{
    event.preventDefault();
    
    // Add loading Class to the button
    jQuery(".dpr-save-btn").addClass('loading').text("<?php echo esc_js(esc_attr__('Saved', 'mec')); ?>");
    jQuery('<div class="wns-saved-settings"><?php echo esc_js(esc_attr__('Settings Saved!', 'mec')); ?></div>').insertBefore('#wns-be-content');
    
    var gateways = jQuery("#mec_gateways_form").serialize();
    jQuery.ajax(
    {
        type: "POST",
        url: ajaxurl,
        data: "action=mec_save_gateways&"+gateways,
        success: function(data)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'mec')); ?>");
                jQuery('.wns-saved-settings').remove();
            }, 1000);

        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Remove the loading Class to the button
            setTimeout(function(){
                jQuery(".dpr-save-btn").removeClass('loading').text("<?php echo esc_js(esc_attr__('Save Changes', 'mec')); ?>");
                jQuery('.wns-saved-settings').remove();
            }, 1000);
        }
    });
});
</script>