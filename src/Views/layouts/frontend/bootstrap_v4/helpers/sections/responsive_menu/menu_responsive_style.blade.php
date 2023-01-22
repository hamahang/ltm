<style>
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #034256;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 16px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        left: 0;
        font-size: 36px;
    }

    #main {
        position: relative;
        height: 100%;
        transition: margin-left .5s;
    }

    #main_shadow {
        display: none;
        background-color: rgba(10, 10, 10, 0.5);
        position: absolute;
        width: 100%;
        height: 100%;
        transition: margin-left .5s;
        padding: 16px;
        z-index: 1000;
    }

    .menu_btn_open_sm
    {
        background: #054358;
        padding: 4px 10px 0px;
        line-height: 25px;
        height: 28px;
        width: 33px;
        border: none;
        cursor: pointer;
    }
</style>