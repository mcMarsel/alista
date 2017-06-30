<div class="text-center">

    <br/>
    <br/>
    <hr/>

    <div class="pull-left"><a href="?set_appLanguage=en">
            <img style="opacity: {{ Lang::getLocale() == 'en' ? '1' : '0.3' }};" src="{{url('packages/flags/us.png')}}"
                 alt="us"/>
        </a>
        <a href="?set_appLanguage=ru_RU.UTF-8">
            <img style="opacity: {{ Lang::getLocale() == 'en' ? '0.3' : '1' }};" src="{{url('packages/flags/ru.png')}}"
                 alt="ru"/>
        </a>
    </div>

    <div class="pull-right">
        <a style="{{ Session::get( 'appTheme', 'light' ) == 'light' ? 'text-decoration: underline' : '' }}"
           href="?set_appTheme=light">light</a>
        |
        <a style="{{ Session::get( 'appTheme', 'light' ) == 'light' ?: 'text-decoration: underline' }}"
           href="?set_appTheme=dark">dark</a>

    </div>

    <div class="clearfix"></div>

    <hr/>

    Development by Vladislav "Exfriend" Otchenashev<br>
    <a href="mailto:i@zlad.tk">i@zlad.tk</a>
    &copy; {{ date('Y') }}


</div>
