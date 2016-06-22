<?php 
    $current = intval(substr(Request::url(), -1));
?>
<div class="positionRelative center-align">
    <p class="lato-regular f16 bold mb5">Step {{$current}} of <span id="countStep">4</span></p>
    <p class="lato-bold bold black-text text-capitalize mb15 f26">{{$page or $step}}</p>
    <ul class="progress-indicator w70 mlAuto mrAuto">
        <?php for ($i = 1; $i <= 4; $i++) { ?>
            <li <?= ($i <= $current) ? "class='completed' data-tooltip='Back to Step " . $i . "'" : ""?> >
                <?php if ($i < $current) { ?>
                    <a href="{{route('index') . '/get-started-' . $i}}">
                <?php } ?>
                        <span class="bubble"></span>
                <?php if ($i < $current) { ?>
                    </a>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>


@section('customCss')
	{!! Html::style('assets/css/progress-wizard.min.css')!!}
	<style type="text/css">
        body, html {
            background-color: #E4E3E3 !important;
        }

		.progress-indicator {
			/* position: fixed; */
            width: 100%;
            top: 0;
            left: 0;
            background: white;
            padding: 0px 0;
            /* border-bottom: 1px solid #e7e7e7; */
		}

		.progress-indicator > li {
			cursor: pointer;
		}

        .progress-indicator > li.completed {
            font-weight: bold;
        }

        .progress-indicator > li.current {
            color: #000;
            font-weight: bold;
        }

        .progress-indicator>li .bubble {
            width: 12px;
            height: 12px;
        }

        .progress-indicator > li.current .bubble,
        .progress-indicator > li.current .bubble:before,
        .progress-indicator > li.current .bubble:after,
        .progress-indicator > li.completed .bubble {
            background-color: #900200;
        }

        .progress-indicator>li .bubble:after, .progress-indicator>li .bubble:before {
            display: none;
        }

        .progress-indicator>li.completed a:hover {
            color: #008813;
        }

        .progress-indicator>li.completed a:hover span {
            background-color: rgba(144, 2, 0, 0.73);
        }

        @media screen and (max-width: 960px), (max-device-width: 960px) and (orientation : portrait) {
            body {
                background-color: #fff !important;
            }
        }
	</style>
@endsection