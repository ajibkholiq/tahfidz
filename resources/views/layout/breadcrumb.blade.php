<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 ">

        <h2 class="text-capitalize">
            {{ str_replace('_', ' ', Request::segment(count(Request::segments())) ?: 'Welcome') }} </h2>
        <ol class="breadcrumb">
            <li>
                @for ($i = 0; $i < count(Request::segments()); $i++)
                    {{ Request::segment($i) }}
                @endfor
                <a class="text-capitalize" href="/{{ Request::segment(count(Request::segments())) }}">
                    {{ str_replace('_', ' ', Request::segment(count(Request::segments()))) }}
                </a>
            </li>
        </ol>
    </div>
</div>
