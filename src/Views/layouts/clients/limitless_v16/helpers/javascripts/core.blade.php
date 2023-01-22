<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEa_E14LcfFFasp2RzFxzXT7XRqT1s92U&sensor=false&libraries=places"></script>
<script type="text/javascript" src="{{ asset('vendor/laravel_task_manager/build/client/js/init_core.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/laravel_task_manager/build/common/js/init_data.min.js') }}"></script>

<script>
    function hide_text_over_flow(el)
    {
        $(el).toggleClass('text_over_flow');
    }
    String.prototype.nums_to_en = function()
    {
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(fa[i], en[i]);
        }
        return r;
    };
    String.prototype.nums_to_fa = function()
    {
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(en[i], fa[i]);
        }
        return r;
    };
</script>