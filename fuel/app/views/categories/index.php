<h2>All Categories</h2>
<p>Manage all categories.</p>
<div class="clear"></div>

<?php if ( $total_categories> 0 ): ?>

<table>
<thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Created On</th>
        <th>Options</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($categories as $category): ?>
    <tr>
        <td width="5%"><?php echo $category->id; ?></td>
        <td><?php echo $category->name; ?></td>
        <td><?php echo $category->description; ?></td>
        <td width="11%"><?php echo Date::Factory($category->created_time)->format("%m/%d/%Y"); ?></td>
        <td width="11%">
            <?php echo Html::anchor('categories/edit/'.$category->id, 'edit'); ?> /
            <?php echo Html::anchor('categories/delete/'.$category->id, 'delete'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>

<div style="text-align:center; padding-top: 10px;"><?php echo Pagination::create_links(); ?></div>

<?php else: ?>
<div class="result" id="notice">
    <span>You did not add any categories. <?php echo Html::anchor('categories/add', 'Add a Category'); ?>.</span>
</div>
<div class="clear"></div>
<?php endif; ?>