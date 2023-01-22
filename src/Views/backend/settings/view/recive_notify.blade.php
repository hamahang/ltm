<form id="frm_recive_notification_setting" class="form-horizontal" name="frm_recive_notification_setting">
    <div id="form_message_box" class="form_message_area"></div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox" @if($setting && $setting->recive_email_is_active =='1') checked @endif name="recive_email_is_active" value="1">
                <span>ایمیل</span>
            </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox" name="recive_sms_is_active" value="1" @if($setting && $setting->recive_sms_is_active == '1') checked @endif>
                <span>پیامک</span>
            </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox"  name="recive_messenger_is_active" value="1" @if($setting && $setting->recive_messenger_is_active =='1') checked @endif>
                <span>پیام رسان</span>
            </label>
        </div>
    </div>
    <div class="space-10"></div>
    <div class="form-group fg_submit  clearfixed col-md-12 text-left">
        <button type="submit" name="submit" class="btn btn-success">ثبت وتایید</button>
    </div>
</form>
