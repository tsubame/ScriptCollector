<div class="scripts form">
<?php echo $this->Form->create('Script'); ?>
	<fieldset>
		<legend><?php echo __('Edit Script'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('url');
		echo $this->Form->input('people_count');
		echo $this->Form->input('man_count　');
		echo $this->Form->input('woman_count');
		echo $this->Form->input('other_count　');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Script.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Script.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Scripts'), array('action' => 'index')); ?></li>
	</ul>
</div>
