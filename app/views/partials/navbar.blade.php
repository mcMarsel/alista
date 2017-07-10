<nav class = "navbar navbar-inverse" role = "navigation">
    <div class = "container">
        <div class = "navbar-header">
            <button type = "button" class = " navbar-toggle collapsed" data-toggle = "collapse" data-target = "#navbar"
                    aria-expanded = "false" aria-controls = "navbar">
                <span class = "sr-only">Toggle navigation</span>
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
            </button>
            <a class = "navbar-brand" href = "{{ url('/') }}"> Metiz </a>
        </div>
        <div id = "navbar" class = "collapse navbar-collapse">
		<ul class = "nav navbar-nav pull-right">
		<li class = "dropdown">
			<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
			Предприятия
            <span class = "caret"></span></a>
            <ul class = "dropdown-menu" role = "menu">
                <li class = "">
                    <a href = "{{ url('addnew') }}">
                        Новое преприятие
                    </a>
                </li>
                <li class = "">
                    <a href = "{{ url('list-client') }}">
                        Список приедприятий
                    </a>
                </li>
            </ul>
		</li>
		<li class = "dropdown">
			<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
			Счет
            <span class = "caret"></span></a>
            <ul class = "dropdown-menu" role = "menu">
                <li class = "">
                    <a href = "{{ url('manager') }}">
                        Новый счет
                    </a>
                </li>
                <li class = "">
                    <a href = "{{ url('accr') }}">
                        Реестр счетов
                    </a>
                </li>
            </ul>
		</li>
		{{--<li class = "dropdown">
            <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
            Заявки на сборку
            <span class = "caret"></span></a>
            <ul class = "dropdown-menu" role = "menu">
                <li class = "">
                    <a href = "{{ url('approved-list') }}">
                        Реестр заявок на сборку
                    </a>
                </li>
            </ul>
        </li>--}}
        @if( Auth::guest() )
            <li><a href = "/login">Войти</a></li>
                @else
                	@if(Auth::getUser()->status == 1)
                    <li class = "dropdown">
                        <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown"> <i
                            class = "fa fa-user"></i> {{ Auth::user()->username  }} <span
                            class = "caret"></span></a>
                        <ul class = "dropdown-menu" role = "menu">
                            <li><a href = "debit">Дебиторка</a></li>
                            <li><a href = "price-list">Прайс-листы</a></li>
                            <li><a href = "setting-main">Настройки</a></li>
                            <li class = "divider"></li>
                            <li><a href = "/logout">Выйти</a></li>
                        </ul>
                    </li>
                    	@else
                    		<li class = "dropdown">
	                        	<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown"> <i
                                    class = "fa fa-user"></i> {{ Auth::user()->username  }} <span
                                    class = "caret"></span></a>
		                        <ul class = "dropdown-menu" role = "menu">
		                        	<li><a href = "debit">Дебиторка</a></li>
		                        	<li><a href = "price-list">Прайс-листы</a></li>
                                    <li class = "divider"></li>
		                            <li><a href = "/logout">Выйти</a></li>
		                        </ul>
		                </li>
                    	@endif
                @endif
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>