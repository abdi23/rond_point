<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        @include('frontend.rondpoint.include._head')
	</head>

	<body class="skin-orange">
        <!-- Header -->
		<header class="primary">
            @include('frontend.rondpoint.include.header')
		</header>

        <!-- Content -->
        @yield('content')

		<!-- Start footer -->
		<footer class="footer">
            @include('frontend.rondpoint.include.footer')
		</footer>
		<!-- End Footer -->

		<!-- JS -->
        @include('frontend.rondpoint.include._scripts')
	</body>
</html>
