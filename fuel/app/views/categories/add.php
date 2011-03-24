<h2>Add a Category</h2>

<?php echo $val->show_errors(); ?>
<?php echo Form::open('categories/add'); ?>

<div class="input text required">
    <?php echo Form::label('Name', 'name'); ?>
    <?php echo Form::input('name', $val->input('name'), array('size' => '30')); ?>
</div>

<div class="input textarea">
    <?php echo Form::label('Description', 'descripton'); ?>
    <?php echo Form::textarea('description', $val->input('description'), array('rows' => 4, 'cols' => 40)); ?>
</div>

<div class="input submit">
    <?php echo Form::submit(array('value' => 'Add Category')); ?>
</div>

<?php echo Form::close(); ?>