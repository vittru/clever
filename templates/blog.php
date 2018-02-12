<?php
include 'header.php';
?>

<section id="aa-blog-archive">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'breadcrumbs.php';
                ?>
                <h1><?php 
                if ($entries)
                    echo 'Блог';
                else 
                    echo $entry->name;
                ?></h1>
                <?php
                if ($isadmin) {
                    if ($entries) {
                ?>
                        <a class="green-button" style="padding: 12px 15px;" href="/editblog">Добавить запись</a>
                <?php
                    } else {
                ?>
                        <a class="orange-button" style="padding: 12px 15px;margin:5px;float:right" href="/editblog/remove?blog=<?php echo $entry->id ?>">Удалить</a>
                        <a class="green-button" style="padding: 12px 15px;margin:5px;float:right" href="/editblog?blog=<?php echo $entry->id ?>">Редактировать</a>

                <?php
                    }
                }    
                ?>
                <div class="aa-blog-archive-area">
                    <div class="row">
                        <!--div class="col-md-9"-->
                            <div class="aa-blog-content <?php //if ($entry) echo 'blog-details' ?>">
                                <?php
                                if ($entry) {
                                ?>
                                    <article class="aa-blog-details">                        
                                        <div class="aa-article-bottom">
                                            <div class="aa-post-date">
                                                <?php echo $entry->date ?>
                                            </div>
                                            <?php
                                            if ($entry->author) {
                                            ?>
                                            <div class="aa-post-author">
                                                Автор: <?php if ($entry->url) echo '<a target="blank" href="' . $entry->url . '">' . $entry->author . '</a>'; else echo $entry->author ?>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <figure class="aa-blog-img">
                                            <img src="<?php echo $entry->getImage() ?>" alt="<?php echo $entry->name ?>">
                                        </figure>
                                        <p><?php echo $entry->text ?></p>
                                    </article>    
                                <?php
                                } else {
                                ?>
                                <!--div class="row"-->
                                    <?php 
                                    if ($entries) 
                                        foreach ($entries as $singleentry) {
                                    ?>
                                    <div class="col-md-3 col-sm-3">
                                        <article class="aa-blog-content-single">                        
                                            <h2><a href="/common/blog?entry=<?php echo $singleentry->id ?>"><?php echo $singleentry->name ?></a></h2>
                                            <div class="aa-article-bottom">
                                                <?php
                                                if ($singleentry->author) {
                                                ?>
                                                <div class="aa-post-author">
                                                    Автор: <?php echo $singleentry->author ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="aa-post-date">
                                                    <?php echo $singleentry->date ?>
                                                </div>
                                            </div>
                                            <figure class="aa-blog-img">
                                                <a href="/common/blog?entry=<?php echo $singleentry->id ?>"><img src="<?php echo $singleentry->getImage() ?>" alt="<?php echo $singleentry->name ?>"></a>
                                            </figure>
                                            <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; height: 48px; width: 100%; text-overflow: ellipsis; white-space: normal;
                                                overflow: hidden;"><?php echo $singleentry->text ?></div>
                                            
                                        </article>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                <!--/div-->
                                <?php
                                }
                                ?>
                            </div>
                        <!--/div-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'footer.php';