<?php global $super_options; ?>

<?php if($super_options[SN.'_sc_enable'] != "false") : ?>
<div class="sticky-contact">
	<a href="" class="mail-alticon- ioa-front-icon trigger"></a>
	<div class="inner-sticky-contact">
		<p class="message"><?php echo stripslashes($super_options[SN.'_sc_message']) ?></p>
		<div class="success"><?php echo stripslashes($super_options[SN.'_sc_sucess_message']) ?></div>
		
		<p>
			<input type="text" value="<?php _e('Enter Name','ioa') ?>"  data-default="<?php _e('Enter Name','ioa') ?>" class='sc_name' name='sc_name' />
			<span class="error-note"><?php _e('Enter a Name','ioa') ?></span>
		</p>
		<p>
			<input type="email" value="<?php _e('Enter Email','ioa') ?>" data-default="<?php _e('Enter Email','ioa') ?>" class='sc_email' name='sc_email' />
			<span class="error-note"><?php _e('Enter a valid Email','ioa') ?></span>
		</p>
		
		<p>
			<textarea name="sc_msg" class='sc_msg' id="" cols="30" data-default="<?php _e('Message','ioa') ?>" rows="10"><?php _e('Message','ioa') ?></textarea>
			<span class="error-note"><?php _e('Message cannot be empty','ioa') ?></span>
		</p>	
					
		<input type="submit" value="<?php _e('Send','ioa'); ?>" data-sending="<?php _e('Sending','ioa'); ?>" data-sent="<?php _e('Sent','ioa'); ?>" class='sc_submit' >
		<input type="hidden" value="<?php echo stripslashes($super_options[SN.'_sc_nemail']) ?>" class="notify_email">
	</div>
</div>
<?php endif; ?>