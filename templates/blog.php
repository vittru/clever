<?php
include 'header.php';
?>

<section id="aa-blog-archive">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php 
                if ($entries)
                    echo 'Блог';
                else 
                    echo $entry['name'];
                ?></h1>
                <div class="aa-blog-archive-area">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="aa-blog-content <?php //if ($entry) echo 'blog-details' ?>">
                                <?php
                                if ($entry) {
                                ?>
                                    <article class="aa-blog-details">                        
                                        <div class="aa-article-bottom">
                                            <div class="aa-post-date">
                                                <?php echo $entry['date'] ?>
                                            </div>
                                            <div class="aa-post-author">
                                                Автор: <?php if ($entry['url']) echo '<a target="blank" href="' . $entry['url'] . '">' . $entry['author'] . '</a>'; else echo $entry['author'] ?>
                                            </div>
                                        </div>
                                        <figure class="aa-blog-img">
                                            <img src="/images/blogs/blog<?php echo $entry['id'] ?>.png" alt="<?php echo $entry['name'] ?>">
                                        </figure>
                                        <p><?php echo $entry['text'] ?></p>
                                    </article>    
                                <?php
                                } else {
                                ?>
                                <div class="row">
                                    <?php 
                                    if ($entries) 
                                        foreach ($entries as $singleentry) {
                                    ?>
                                    <div class="col-md-4 col-sm-4">
                                        <article class="aa-blog-content-single">                        
                                            <h2><a href="/common/blog?entry=<?php echo $singleentry['id'] ?>"><?php echo $singleentry['name'] ?></a></h2>
                                            <div class="aa-article-bottom">
                                                <div class="aa-post-author">
                                                    Автор: <?php echo $singleentry['author'] ?>
                                                </div>
                                                <div class="aa-post-date">
                                                    <?php echo $singleentry['date'] ?>
                                                </div>
                                            </div>
                                            <figure class="aa-blog-img">
                                                <a href="/common/blog?entry=<?php echo $singleentry['id'] ?>"><img src="/images/blogs/blog<?php echo $singleentry['id'] ?>.png" alt="<?php echo $singleentry['name'] ?>"></a>
                                            </figure>
                                            <?php echo $singleentry['text'] ?>
                                        </article>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'footer.php';