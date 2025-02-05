
    <script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/css/flex2html.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/gh/PamornT/flex2html@main/js/flex2html.min.js" type="text/javascript"></script>
    <style type="text/css">
      .body_block{
        opacity: 0.8;
        z-index:9999;
        display: none;
      }

      .loader {
        position: relative;
        width: 45px;
        height: 45px;
        left: 50%;
        top: 50%;
        margin-left: -22px;
        margin-top: 2px;
        -webkit-animation: rotate 1s infinite linear;
        -moz-animation: rotate 1s infinite linear;
        -ms-animation: rotate 1s infinite linear;
        -o-animation: rotate 1s infinite linear;
        animation: rotate 1s infinite linear;
        border: 3px solid rgba(0, 0, 0, 1);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
      }
      .loader span {
        position: absolute;
        width: 45px;
        height: 45px;
        top: -3px;
        left: -3px;
        border: 3px solid transparent;
        border-top: 3px solid rgba(255, 255, 255, 1);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
      }
      @-webkit-keyframes rotate {
        0% {
          -webkit-transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
        }
      }
      @keyframes rotate {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      .chatbox{
        width: auto;
        min-width: 500px;
      }

      .LySlider{
        overflow: unset !important;
        overflow-x: unset !important;
      }
    </style>