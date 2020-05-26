<?php Core\View::render('templates\\navbar'); ?>
    
    <main>
        
        <section class="policy-area section-padding pb-125 fix wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
            <div class="container">

                <div class="row mtn-30">
        
                    <?php foreach($news as $new): ?>

                        <div class="col-lg-3 col-md-6">
                            <div class="service-policy-item mt-30">
                                <a href="/news/<?php echo $new->id ?>">
                                    <h3 class="service-policy-title"><?php echo $new->title; ?></h3>
                                </a>
                                <p class="service-policy-desc"><?php echo $new->description; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
        
                </div>

            </div>
        </section>

        <div class="container center">
            <?php if($pagination->countPages > 1): ?>
                <?= $pagination;  ?>
            <?php endif; ?>
        </div>

</body>

</html>