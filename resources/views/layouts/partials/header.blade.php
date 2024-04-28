<div class="da-header">
    <!-- begin: Header container -->
    <div class="container d-flex align-items-stretch justify-content-between">
        <!-- begin: Logo and Menu -->
        <div class="d-flex flex-grow-1 flex-lg-grow-0">
            <!-- begin: Logo -->
            <div class="d-flex align-items-center mr-5">
                <a href="{{ route('painel') }}" class="d-flex align-items-center mr-5">
                    <img src="{{ asset('assets/images/white-icon.png') }}" alt="Logo" class="d-md-none d-inline da-logo">
                    <img src="{{ asset('assets/images/logo-white.png') }}" alt="Logo" class="d-none d-md-inline da-logo">
                </a>
            </div>
            <!-- end: Logo -->

            <!-- begin: Menu Wrapper -->
            <div class="d-flex align-items-stretch">
                <!-- begin: Menu -->
                <div class="da-menu">
                    <!-- begin: Menu item -->
                    <div class="da-menu__item">
                        <!-- begin: Menu link -->
                        <a href="{{ route('painel') }}" class="da-menu__link" alt="Dashboard">Dashboard</a>
                        <!-- end: Menu link -->
                    </div>
                    <!-- end: Menu item -->
                    <!-- begin: Menu item -->
                    <div class="da-menu__item">
                        <!-- begin: Menu link -->
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="da-menu__link dropdown-toggle" alt="Gerenciar">Gerenciar</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(empty(Auth::user()->associate_id))
                                    <a class="dropdown-item" href="{{ route('product.category.index') }}">Categorias</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('enrollment.index') }}">Inscrições</a>
                                @if(empty(Auth::user()->associate_id))
                                    <a class="dropdown-item" href="{{ route('award.index') }}">Premiações</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('product.index') }}">Produtos</a>
                            </div>
                        </div>
                        <!-- end: Menu link -->
                    </div>
                    <!-- end: Menu item -->
                    <!-- begin: Menu item -->
                    <div class="da-menu__item">
                        <!-- begin: Menu link -->
                        @if(!empty(Auth::user()->associate_id))
                            <a href="{{ route('associate.profile') }}" class="da-menu__link" alt="Associados">Meu Cadastro</a>
                        @else
                            <div class="dropdown">
                                <a href="{{ route('associate.index') }}" class="da-menu__link dropdown-toggle" alt="Associados">Associados</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('associate.newsletter') }}">Newsletter</a>
                                </div>
                            </div>
                        @endif
                        <!-- end: Menu link -->
                    </div>
                    <!-- end: Menu item -->
                    @if(empty(Auth::user()->associate_id))
                    <!-- begin: Menu item -->
                    <div class="da-menu__item">
                        <!-- begin: Menu link -->
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="da-menu__link dropdown-toggle" alt="Relatórios">Relatórios</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('report.associate') }}">Associados</a>
                                <a class="dropdown-item" href="{{ route('report.product') }}">Produtos</a>
                                <a class="dropdown-item" href="{{ route('report.vote') }}">Votos</a>
                            </div>
                        </div>
                        <!-- end: Menu link -->
                    </div>
                    <!-- end: Menu item -->

                    <!-- begin: Menu item -->
                    <div class="da-menu__item">
                        <!-- begin: Menu link -->
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="da-menu__link dropdown-toggle" alt="Configurações">Configurações</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('user.index') }}">Usuários</a>
                            </div>
                        </div>
                        <!-- end: Menu link -->
                    </div>
                    <!-- end: Menu item -->
                    @endif
                </div>
                <!-- end: Menu -->
            </div>
            <!-- end: Menu Wrapper -->

        </div>
        <!-- end: Logo and Menu -->

        <!-- begin: Navbar -->
        <div class="d-flex flex-grow-1 flex-lg-grow-0">
            <div class="d-flex align-items-center ml-5">
                <div class="d-flex align-items-stretch">
                    <div class="da-menu">
                        <!-- begin: Menu item -->
                        <div class="da-menu__item">
                            <!-- begin: Menu link -->
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="da-menu__link dropdown-toggle" alt="{{ Auth::user()->name }}">{{ Auth::user()->name }}</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Sair</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <!-- end: Menu link -->
                        </div>
                        <!-- end: Menu item -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Navbar -->
    </div>
    <!-- end: Header container -->
</div>
