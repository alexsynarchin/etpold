<nav class="main-nav main-nav--animation">
    <div class="container">
        <div class="row">
            <ul class="main-nav__list">
                <li class="{{ Request::is( '/') ? 'main-nav__item--active' : '' }} main-nav__item  ">
                    <a href="/" class="main-nav__link">Главная</a>
                </li>
                <li class="{{ Request::is( 'biddings') ? 'main-nav__item--active' : '' }} main-nav__item">
                    <a href="/biddings" class=" main-nav__link">Торги</a>
                </li>
                <li class="{{ Request::is( 'about') ? 'main-nav__item--active' : '' }} main-nav__item ">
                    <a href="/about" class="{{ Request::is( 'about') ? 'main-nav__item--active' : '' }} main-nav__link ">О площадке</a>
                </li>
                <li class="{{ Request::is( 'customers') ? 'main-nav__item--active' : '' }} main-nav__item">
                    <a href="/customers" class="main-nav__link">Заказчикам</a>
                </li>
                <li class="{{ Request::is( 'suppliers') ? 'main-nav__item--active' : '' }} main-nav__item">
                    <a href="/suppliers" class=" main-nav__link">Участникам</a>
                </li>
                <li class="{{ Request::is( 'rates') ? 'main-nav__item--active' : '' }} main-nav__item">
                    <a href="/rates" class=" main-nav__link">Тарифы</a>
                </li>
                <li class="{{ Request::is( 'contact') ? 'main-nav__item--active' : '' }} main-nav__item">
                    <a href="/contact" class="main-nav__link">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
</nav>