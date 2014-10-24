<div class="scripts view">
<h2><?php echo __('Script'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($script['Script']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($script['Script']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($script['Script']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('People Count'); ?></dt>
		<dd>
			<?php echo h($script['Script']['people_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Man Count　'); ?></dt>
		<dd>
			<?php echo h($script['Script']['man_count　']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Woman Count'); ?></dt>
		<dd>
			<?php echo h($script['Script']['woman_count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Other Count　'); ?></dt>
		<dd>
			<?php echo h($script['Script']['other_count　']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($script['Script']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($script['Script']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Script'), array('action' => 'edit', $script['Script']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Script'), array('action' => 'delete', $script['Script']['id']), null, __('Are you sure you want to delete # %s?', $script['Script']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Scripts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Script'), array('action' => 'add')); ?> </li>
	</ul>
</div>
