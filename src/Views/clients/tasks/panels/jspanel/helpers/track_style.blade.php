<style>
    .ltm-timeline {
        list-style: none;
        padding: 20px 0 20px;
        position: relative;
    }

    .ltm-timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .ltm-timeline > li {
        margin-bottom: 20px;
        position: relative;
    }

    .ltm-timeline > li:before,
    .ltm-timeline > li:after {
        content: " ";
        display: table;
    }

    .ltm-timeline > li:after {
        clear: both;
    }

    .ltm-timeline > li:before,
    .ltm-timeline > li:after {
        content: " ";
        display: table;
    }

    .ltm-timeline > li:after {
        clear: both;
    }

    .ltm-timeline > li > .ltm-timeline-panel {
        width: 44%;
        float: left;
        border: 1px solid #d4d4d4;
        border-radius: 2px;
        padding: 20px;
        position: relative;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }

    .ltm-timeline > li > .ltm-timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " ";
    }

    .ltm-timeline > li > .ltm-timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }

    .ltm-timeline > li > .ltm-timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .ltm-timeline > li.ltm-timeline-inverted > .ltm-timeline-panel {
        float: right;
    }

    .ltm-timeline > li.ltm-timeline-inverted > .ltm-timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }

    .ltm-timeline > li.ltm-timeline-inverted > .ltm-timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    .ltm-timeline-badge.primary {
        background-color: #2e6da4 !important;
    }

    .ltm-timeline-badge.success {
        background-color: #3f903f !important;
    }

    .ltm-timeline-badge.warning {
        background-color: #f0ad4e !important;
    }

    .ltm-timeline-badge.danger {
        background-color: #d9534f !important;
    }

    .ltm-timeline-badge.info {
        background-color: #5bc0de !important;
    }

    .ltm-timeline-title {
        margin-top: 0;
        color: inherit;
    }

    .ltm-timeline-body > p,
    .ltm-timeline-body > ul {
        margin-bottom: 0;
    }

    .ltm-timeline-body > p + p {
        margin-top: 5px;
    }

    @media (max-width: 767px) {
        ul.ltm-timeline:before {
            left: 40px;
        }

        ul.ltm-timeline > li > .ltm-timeline-panel {
            width: calc(100% - 90px);
            width: -moz-calc(100% - 90px);
            width: -webkit-calc(100% - 90px);
        }

        ul.ltm-timeline > li > .ltm-timeline-badge {
            left: 15px;
            margin-left: 0;
            top: 16px;
        }

        ul.ltm-timeline > li > .ltm-timeline-panel {
            float: right;
        }

        ul.ltm-timeline > li > .ltm-timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.ltm-timeline > li > .ltm-timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
    }
</style>