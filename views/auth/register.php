<?php Core\View::render('templates\\navbar'); ?>


    <section class="policy-area section-padding pb-125 fix wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
        
        <div class="container">
        <h1 class="text-center">Регистрация</h1>
        
            <div class="form">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Email" 
                                    name="email"
                                >
                                
                                <?php if(isset($errors['email'])) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            <?php foreach($errors['email'] as $error): ?>
                                                <li>
                                                    <?= $error ?>
                                                </li>
                                            <?php endforeach; ?>    
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                            <div class="col-sm-10">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    placeholder="Пароль" 
                                    name="password"
                                >
                            
                                <?php if(isset($errors['password'])) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            <?php foreach($errors['password'] as $error): ?>
                                                <li>
                                                    <?= $error ?>
                                                </li>
                                            <?php endforeach; ?>    
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember_me"> Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <button class="btn btn-hero" type="submit">Зарегистрироваться</button>
                        </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>