/**
 *
 * @param function_name
 * @returns {boolean}
 */
function function_exists(function_name)
{
    //return eval('typeof ' + function_name) === 'function';
    /*
    if ('string' === typeof function_name)
    {
        function_name = this.window[function_name];
    }
    return typeof 'function' === function_name;
    */
}

function task_reload_automatically()
{
    //if (function_exists('datatable_reload')) { datatable_reload(); }
}