<form id="frm_send_notification_setting" class="form-horizontal" name="frm_send_notification_setting">
    <div id="form_message_box" class="form_message_area"></div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox" class="setting_email" id="setting_email" @if($setting && $setting->is_acive_email =='1') checked @endif name="is_acive_email" value="1">
                <span>ایمیل</span>
            </label>
        </div>
        <div class="col-sm-10 fg_setting_email" @if(!$setting || ($setting && $setting->is_acive_email !='1')) style="display: none" @endif >
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_email_users" name="responsible_email" value="1" @if($setting && $setting->responsible_email =='1') checked @endif>
                    <span>مسئولین</span>
                </label>
            </div>
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_email_transcripts" name="transcript_email" value="1" @if($setting && $setting->transcript_email =='1') checked @endif>
                    <span>رونوشت گیرندگان</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox" class="setting_sms" id="setting_sms" name="is_acive_sms" value="1" @if($setting && $setting->is_acive_sms =='1') checked @endif>
                <span>پیامک</span>
            </label>
        </div>
        <div class="col-sm-10 fg_setting_sms" @if(!$setting || ($setting && $setting->is_acive_sms !='1'))  style="display: none" @endif >
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_sms_users" name="responsible_sms" value="1" @if($setting && $setting->responsible_sms =='1') checked @endif>
                    <span>مسئولین</span>
                </label>
            </div>
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_sms_transcripts" name="transcript_sms" value="1" @if($setting && $setting->transcript_sms =='1') checked @endif>
                    <span>رونوشت گیرندگان</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="checkbox-inline col-sm-2">
            <label>
                <input type="checkbox" class="setting_messaging" id="setting_messaging" name="is_acive_messenger" value="1" @if($setting && $setting->is_acive_messenger =='1') checked @endif>
                <span>پیام رسان</span>
            </label>
        </div>
        <div class="col-sm-10 fg_setting_messaging" @if(!$setting || ($setting && $setting->is_acive_messenger !='1')) style="display: none" @endif >
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_messaging_users" name="responsible_messenger" value="1" @if($setting && $setting->responsible_messenger =='1') checked @endif>
                    <span>مسئولین</span>
                </label>
            </div>
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" class="" id="setting_messaging_transcripts" name="transcript_messenger" value="1" @if($setting && $setting->transcript_messenger =='1') checked @endif>
                    <span>رونوشت گیرندگان</span>
                </label>
            </div>
        </div>
    </div>
    <div class="space-10"></div>
    <div class="form-group fg_submit  clearfixed col-md-12 text-left">
        <button type="submit" name="submit" class="btn btn-success">ثبت وتایید</button>
    </div>
</form>
