<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Stationwagon<?php echo isset($title) ? ' - '.$title : null; ?></title>

        <?php echo Asset::css(array('stationwagon.css')); ?>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <h1>Stationwagon
                    <sub style="font-weight: normal; font-size: 12px;">
                        <a href="https://github.com/abdelm/stationwagon/">Fork on Github</a>
                    </sub>
                </h1>
            </div>

            <ul class="nav">
                <?php if ( $logged_in ): ?>
                <li><?php echo Html::anchor('articles', 'All Articles'); ?></li>
                <li><?php echo Html::anchor('articles/add', 'Add Article'); ?></li>
                <li><?php echo Html::anchor('categories', 'All Categories'); ?></li>
                <li><?php echo Html::anchor('categories/add', 'Add Category'); ?></li>
				<li><?php echo Html::anchor('users/logout', 'Logout'); ?></li>
				<?php else: ?>
				<li><?php echo Html::anchor('users/login', 'Login'); ?></li>
				<li><?php echo Html::anchor('users/signup', 'Sign Up'); ?></li>
				<?php endif; ?>
            </ul>
        </div>

        <div class="content">
            <?php if (Session::get_flash('success')): ?>
            <div class="result" id="success"><span><?php echo Session::get_flash('success'); ?></span></div>
            <div class="clear"></div>
            <?php elseif (Session::get_flash('notice')): ?>
            <div class="result" id="notice"><span><?php echo Session::get_flash('notice'); ?></span></div>
            <div class="clear"></div>
            <?php elseif (Session::get_flash('error')): ?>
            <div class="result" id="error"><span><?php echo Session::get_flash('error'); ?></span></div>
            <div class="clear"></div>
            <?php endif; ?>
            
            <?php echo $content; ?>
        </div>

        <div class="footer">
            <div class="right">Page renedered in {exec_time}s | Memory Usage {mem_usage}MB</div>
            <div class="left">Developed by <a href="http://aplusm.me">Abdelrahman Mahmoud</a>
                and <a href="http://twitter.com/Alfie_Rivera">Alfredo Rivera</a>.</div>
        </div>

        <?php echo Asset::js(array('jquery.min.js', 'sw-core.js')); ?>
    </body>
</html>