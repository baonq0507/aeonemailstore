<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = "{{ $livechat_id }}";
        (function(n, t, c) {
            function i(n) {
                return e._h ? e._h.apply(null, n) : e._q.push(n)
            }
            var e = {
                _q: [],
                _h: null,
                _v: "2.0",
                on: function() {
                    i(["on", c.call(arguments)])
                },
                once: function() {
                    i(["once", c.call(arguments)])
                },
                off: function() {
                    i(["off", c.call(arguments)])
                },
                get: function() {
                    if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                    return i(["get", c.call(arguments)])
                },
                call: function() {
                    i(["call", c.call(arguments)])
                },
                init: function() {
                    var n = t.createElement("script");
                    n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
                }
            };
            !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
        }(window, document, [].slice))
    </script>
    <script>
        LiveChatWidget.call("hide");

        LiveChatWidget.on('visibility_changed', onVisibilityChanged)
        const openLiveChat = () => {
            LiveChatWidget.call('maximize')
        }

        function onVisibilityChanged(data) {
            switch (data.visibility) {
                case "maximized":
                    break;
                case "minimized":
                    LiveChatWidget.call('hide')
                    break;
                case "hidden":
                    break;
            }
        }
    </script>
    <style>
        .modal-notification {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            overflow: auto;
            z-index: 999;
            transition: 0.4s all;
            opacity: 0;
            visibility: hidden;
            cursor: pointer;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .modal-notification *,
        .modal-notification *:before,
        .modal-notification *:after {
            -webkit-box-sizing: inherit;
            -moz-box-sizing: inherit;
            box-sizing: inherit;
        }

        .modal-notification_visible {
            opacity: 1;
            visibility: visible;
        }

        .modal-table {
            display: table;
            width: 100%;
        }

        .modal-table-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 15px;
        }

        .modal {
            transition: 0.4s all;
            display: inline-block;
            max-width: 500px;
            width: 100%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.25);
            color: #333;
            text-align: left;
            font-family: Arial;
            margin: 30px 0;
            transform: translate(0, 20%);
            position: relative;
            border-radius: 4px 6px 4px 4px;
            cursor: auto;
            font-size: 16px;
        }

        .modal-notification_visible .modal {
            transform: translate(0);
        }

        .modal__header {
            font-size: 22px;
            font-weight: 400;
            padding: 0 0 30px 0;
        }

        .modal__content p {
            padding: 0 0 10px 0;
            margin: 0;
        }

        .modal__close {
            position: absolute;
            right: 20px;
            top: 10;
            height: 25px;
            border-radius: 0 0 4px 4px;
            transition: 0.4s all;
            padding: 0;
            border: none;
            cursor: pointer;
        }

        .modal__close:hover {
            background: #ed5f55;
        }

        .modal__close:before,
        .modal__close:after {
            content: "";
            display: block;
            height: 16px;
            width: 1px;
            transform: rotate(45deg);
            background: #222;
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            top: 0;
            bottom: 0;
        }

        .modal__close:after {
            transform: rotate(-45deg);
        }
    </style>
    @stack('css')
</head>

<body>
    @yield('content')
    @if(!request()->is('login') && !request()->is('register') && $imageNotification)
    <div class="modal-notification" data-modal="test">
        <div class="modal-table">
            <div class="modal-table-cell">
                <div class="modal">
                    <button class="modal__close"></button>
                    <div class="modal__content">
                        <img src="{{ $imageNotification }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/index.js') }}"></script>
    <script>
        $('#livechat, #customer-service').click(function(e) {
            e.preventDefault();
            openLiveChat()
        })
    </script>
    @if(!request()->is('login') && !request()->is('register') && $imageNotification && !Cookie::get('modal_shown'))
    <script>
        $(document).ready(function() {
            $('.modal-notification[data-modal="test"]').addClass("modal-notification_visible");

            // Function to close a modal window by clicking on a button

            $(".modal__close").on("click", function() {
                $(".modal-notification").removeClass("modal-notification_visible");
            });

            // Function to close the modal window by clicking outside the window

            $(document).on("click", function(e) {
                if ($(".modal-notification_visible").length) {
                    // If there is an open window

                    if (
                        !$(e.target).closest(".modal").length &&
                        !$(e.target).closest(".modal-link").length
                    ) {

                        // If clicked outside its content and not on the call link

                        $(".modal-notification").removeClass("modal-notification_visible");
                    }
                }
            });
        });
    </script>
    @endif
    @if(auth()->check())
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        });

        pusher.subscribe('user-channel-{{ auth()->user()->id }}')
            .bind('update-balance', function(data) {
                Swal.fire({
                    title: "{{ __('mess.update_balance_deposit_title') }}",
                    text: data,
                    icon: 'success',
                });

                const deposit_btn = $('#deposit_btn');
                if (deposit_btn.length) {
                    deposit_btn.prop('disabled', false);
                    deposit_btn.html("{{__('mess.deposit')}}");
                }
            });
    </script>
    @endif
    @stack('script')
</body>

</html>
