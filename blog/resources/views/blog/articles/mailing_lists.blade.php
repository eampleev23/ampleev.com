<div class="mb-4">
    <h5>Рассылки</h5>
    <form action="/forms/mailchimp.php" data-form-email novalidate>
        <div class="form-row">
            <div class="col-12">
                <input type="email" class="form-control mb-2" placeholder="Email" name="email"
                       required>
            </div>
            <div class="col-12">
                <div class="d-none alert alert-success" role="alert" data-success-message>
                    Thanks, a member of our team will be in touch shortly.
                </div>
                <div class="d-none alert alert-danger" role="alert" data-error-message>
                    Please fill all fields correctly.
                </div>
                <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                     data-size="invisible" data-badge="bottomleft">
                </div>
                <button type="submit" class="btn btn-primary btn-loading btn-block"
                        data-loading-text="Sending">
                    <img class="icon" src="assets/img/icons/theme/code/loading.svg"
                         alt="loading icon"
                         data-inject-svg/>
                    <span>Подписаться</span>
                </button>
            </div>
        </div>
    </form>
    <small class="text-muted form-text">Мы никогда не раскроем ваши данные. Смотрите наши <a
                href="#">Условия
            Конфиденциальности</a>
    </small>
</div>