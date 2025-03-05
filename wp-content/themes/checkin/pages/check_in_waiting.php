<?php
//Template Name: Check In Waiting
get_header();

require_once DIR_MODEL . 'model-check-in-event-function.php';
$model = new Model_Check_In_Event_Function();
$event = $model->getActiveItem();
?>
<div class="waiting_container">
    <div class="waiting-title"><?php echo $event['title'] ?></div>
    <label ID="waiting_txt"><?php echo get_post_meta('1', '_text_waiting', true); ?></label>
</div>


<style>
    #waiting_txt {
        position: absolute;
        font-size: 50px;
        font-weight: bold;
        letter-spacing: 10px;
        -webkit-animation-name: example;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-duration: 10s;
        /* Safari 4.0 - 8.0 */
        -webkit-animation-iteration-count: infinite;
        /* Safari 4.0 - 8.0 */
        animation-name: example;
        animation-duration: 10s;
        animation-iteration-count: infinite;

    }


    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes example {
        0% {
            color: #fff;
            font-size: 60px
        }

        20% {
            color: #fff;
            font-size: 60px
        }

        40% {
            color: #FC9105;
            font-size: 72px
        }

        41% {
            color: #FC9105;
            font-size: 70px
        }

        42% {
            color: #FC9105;
            font-size: 71px
        }

        50% {
            color: #FC9105;
            font-size: 70px
        }

        70% {
            color: #FC9105;
            font-size: 70px
        }

        100% {
            color: #333;
            font-size: 60px;
        }
    }

    /* Standard syntax */
    @keyframes example {
        0% {
            color: #fff;
            font-size: 60px
        }

        20% {
            color: #fff;
            font-size: 60px
        }

        40% {
            color: #FC9105;
            font-size: 72px
        }

        41% {
            color: #FC9105;
            font-size: 70px
        }

        42% {
            color: #FC9105;
            font-size: 71px
        }

        50% {
            color: #FC9105;
            font-size: 70px
        }

        70% {
            color: #FC9105;
            font-size: 70px
        }

        100% {
            color: #fff;
            font-size: 60px;
        }
    }
</style>