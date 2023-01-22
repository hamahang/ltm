<style>
    .task-progress
    {
        margin-bottom: 15px;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .task-progress .task-progress-client
    {
        margin: auto auto 15px auto;
        min-width: 950px;
        text-align: center;
    }
    .task-progress .task-progress-client > div
    {
        display: inline-block;
        height: 100px;
    }
    .task-progress .task-progress-client > div.F,
    .task-progress .task-progress-client > div.P,
    .task-progress .task-progress-client > div.M,
    .task-progress .task-progress-client > div.N,
    .task-progress .task-progress-client > div.L
    {
        background-color: #f5f5f5;
        padding: 5px;
        vertical-align: middle;
        width: 100px;
    }
    .task-progress .task-progress-client > div.P,
    .task-progress .task-progress-client > div.N,
    .task-progress .task-progress-client > div.P img,
    .task-progress .task-progress-client > div.N img
    {
        border-radius: 50%;
    }
    .task-progress .task-progress-client > div.connector-direct,
    .task-progress .task-progress-client > div.connector-indirect
    {
        height: 0 !important;
        margin-top: 50px;
    }
    .task-progress .task-progress-client > div.connector-direct
    {
        border-top: 2px solid lightgray;
        width: 75px;
    }
    .task-progress .task-progress-client > div.connector-indirect
    {
        border-top: 2px dashed lightgray;
        width: 120px;
    }
    .task-progress .task-progress-client > div.F,
    .task-progress .task-progress-client > div.F img
    {
        border-radius: 10%;
        clip-path: polygon(25% 0%, 100% 1%, 100% 100%, 25% 100%, 0% 50%);
    }
    .task-progress .task-progress-client > div.P,
    .task-progress .task-progress-client > div.P img
    {
        border-radius: 50%;
    }
    .task-progress .task-progress-client > div.M,
    .task-progress .task-progress-client > div.M img
    {
        border-radius: 10%;
    }
    .task-progress .task-progress-client > div.M
    {
        height: 132px;
        width: 132px;
    }
    .task-progress .task-progress-client > div.M img
    {
    }
    .task-progress .task-progress-client > div.N
    {
        border-radius: 50%;
    }
    .task-progress .task-progress-client > div.L,
    .task-progress .task-progress-client > div.L img
    {
        border-radius: 10%;
        clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);
    }
    .task-progress .task-progress-client > div img
    {
        width: 100%;
    }
</style>
<div class="task-progress">
    <div class="task-progress-client">
        {!! $progress['template'] !!}<br /><br />
    </div>
</div>
<script>$('[data-popup="tooltip"]').tooltip();</script>
<hr />
