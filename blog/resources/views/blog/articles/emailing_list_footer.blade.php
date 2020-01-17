<section class="pt-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <h3 class="h2 mb-5">Получайте новости о новых публикациях прямо на свой email</h3>
                <form action="/forms/mailchimp.php" data-form-email novalidate>
                    <div class="d-sm-flex flex-column flex-sm-row mb-3 justify-content-center">
                        <input type="email" name="email" class="mr-sm-1 mb-2 mb-sm-0 form-control form-control-lg"
                               placeholder="Email" required>
                        <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                             data-size="invisible"
                             data-badge="bottomleft"></div>

                        <button type="submit" class="ml-sm-1 btn btn-lg btn-primary btn-loading"
                                data-loading-text="Sending">
                            <img class="icon" src="assets/img/icons/theme/code/loading.svg" alt="loading icon"
                                 data-inject-svg/>
                            <span>Подписаться</span>
                        </button>

                    </div>
                    <div>
                        <div class="d-none alert alert-success" role="alert" data-success-message>
                            Спасибо за ваш интерес, мы отправили вам на почту ссылку для подтверждения Она актуальна в течение
                            24 часов.
                        </div>
                        <div class="d-none alert alert-danger" role="alert" data-error-message>
                            Пожалуйста, используйте валидный email.
                        </div>
                    </div>
                </form>

                <div class="text-small text-muted">
                   Мы никогда не передадим ваши данные третим лицам.
                    <br class="visible-md"/>Посмотрите наши <a target="_blank"
                                                               href="{{route('docs.terms_of_use')}}">Пользовательское соглашение</a> и <a
                            target="_blank"
                            href="{{route('docs.terms_of_use')."#support"}}">Политику Конфиденциальности</a> для более подробной информации.
                </div>
            </div>
        </div>
    </div>
</section>
