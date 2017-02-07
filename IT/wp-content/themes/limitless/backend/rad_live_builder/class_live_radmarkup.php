<?php
class RADLiveMarkup
	{
		
		static function generateRADSection($values=array(),$id='',$containers = array(),$clone = false,$force_value=false)
		{
			global $radunits;
			

			if($clone) {  $id = '{ID}'; echo '<script type="text/template" id="RADSectionView">'; }
			?>
			<div class="page-section clearfix" id='<?php echo $id; ?>'>
				<div class="skeleton section-content auto_align clearfix">
				</div>
				<?php get_template_part('backend/rad_live_builder/section_toolbar'); ?>
			</div>
			<?php
			if($clone) echo "</script>";
			?>
			<script type="text/template" id="sectionToolbar"><?php get_template_part('backend/rad_live_builder/section_toolbar'); ?></script> <?php
		}

		

		static function generateRADContainer($values = array(),$id ='',$layout='full',$widgets = array(),$clone = false,$force_value=false)
		{
			global $radunits;
			

			if($clone) {  $id = '{ID}'; echo '<script type="text/template" id="RADContainerView">'; }
			?>

			<div class="rad-container  layout_element <?php echo $layout; ?> clearfix" id="<?php echo $id ?>">
					<div class="rad-inner-container nested clearfix">
					</div>
					<?php get_template_part('backend/rad_live_builder/container_toolbar'); ?>
			</div>		
			<?php
			if($clone) echo "</script>"; ?>
			<script type="text/template" id="containerToolbar"><?php get_template_part('backend/rad_live_builder/container_toolbar'); ?></script> <?php
			
		}

		static function generateRADWidget()
		{

		$id = '{ID}'; echo '<script type="text/template" id="RADWidgetView">'; 
			?>

			<div class="clearfix page-rad-component rad-component-spacing default_rad_stub rad_page_widget" id="<?php echo $id ?>" data-key=''>
						<h4 class="rad-s-title"></h4>
					<?php get_template_part('backend/rad_live_builder/widget_toolbar'); ?>
					<div class="rad-w-progress-bar"><div class="filler"></div></div>
			</div>		
			<?php
		 echo "</script>"; ?>
		 <script type="text/template" id="widgetToolbar"><?php get_template_part('backend/rad_live_builder/widget_toolbar'); ?></script> <?php
			
		}

		static function generateRADSectionDrop()
		{

		 echo '<script type="text/template" id="sectionDropper">'; 
			?>

			<div class="clearfix section-dropper-helper" >
					<h4>Drop Widget Here</h4>
			</div>		
			<?php
		 echo "</script>"; ?>
		 <?php
			
		}

		static function generateRADContainerDrop()
		{

		 echo '<script type="text/template" id="containerDropper">'; 
			?>

			<div class="clearfix container-dropper-helper" >
					<h4>Drop Widget Here</h4>
			</div>		
			<?php
		 echo "</script>"; ?>
		 <?php
			
		}



	}