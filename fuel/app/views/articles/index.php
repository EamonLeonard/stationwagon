<h2>All Articles</h2>
<p>Manage all your articles.</p>
<div class="clear"></div>

<?php if ( $total_articles > 0 ): ?>

<div class="filters">
    <strong>Show:</strong>
    <a href="#">Published</a>
    <a href="#">Drafts</a>
</div>

<div id="loading"></div>

<div id="articles">
    <table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Title</th>
            <th>Body</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td width="5%"><?php echo $article->id; ?></td>
            <td><?php echo ($article->category_id != 0) ? $article->category->name : 'Uncategorized'; ?></td>
            <td><?php echo $article->title; ?></td>
            <td><?php echo $article->body; ?></td>
            <td width="7%">
                <?php
                if ( $article->published == 1 )
                {
                    echo 'Published';
                }
                else
                {
                    echo Html::anchor('articles/publish/'.$article->id, 'Draft', array('title' => 'Click to Publish'));
                }
                ?>
            </td>
            <td width="11%"><?php echo Date::Factory($article->created_time)->format("%m/%d/%Y"); ?></td>
            <td width="11%">
                <?php echo Html::anchor('articles/edit/'.$article->id, 'edit'); ?> /
                <?php echo Html::anchor('articles/delete/'.$article->id, 'delete'); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<div style="text-align:center; padding-top: 10px;"><?php echo Pagination::create_links(); ?></div>

<?php else: ?>
<p style="color: red;">You did not add any articles. <?php echo Html::anchor('articles/add', 'Add an Article'); ?>.</p>
<?php endif; ?>