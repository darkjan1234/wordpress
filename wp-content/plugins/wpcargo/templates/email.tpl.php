<div class="wpc-email-notification-wrap" style="width: 100%; font-family: sans-serif;">
    <div class="wpc-email-notification" style="padding: 16px; background: #efefef;">
        <div class="wpc-email-template" style="background: #fff; width: 460px; margin: 0 auto; padding: 2em">
            <div class="wpc-email-notification-logo" style="text-align: center;">
                <img src="<?php echo esc_url( $brand_logo ); ?>" width="160" style="margin:0 auto;"/>
            </div>
            <div class="wpc-email-notification-content" style="padding: 2em 0; font-size: 14px;">
                <?php echo wp_kses( $email_body, 'post' ); ?>
            </div>
        </div>
        <div class="wpc-email-notification-footer" style="width: 460px; font-size: 10px; text-align: center; margin: 0 auto; padding: 2em;">
              <?php echo wp_kses( $email_footer, 'post' ); ?>
          </div>
    </div>
</div>