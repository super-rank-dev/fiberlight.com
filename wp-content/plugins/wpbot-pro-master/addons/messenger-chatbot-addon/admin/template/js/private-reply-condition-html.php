<div class="fb_condition_item" data-itemid="placeholder">
    <span class="fb_condition_item_close">x</span>
    <div class="wpfb_private_reply_conditional_area">
        <input type="radio" name="wpfb_private_reply_condition[placeholder]" checked="checked" value="0" />
        <i><?php echo esc_html__('Reply anytime', 'wpfb'); ?></i>
        <input type="radio" name="wpfb_private_reply_condition[placeholder]" value="1" />
        <i><?php echo esc_html__('Reply if', 'wpfb'); ?></i>
        
        <div class="wpfb_logical_container" style="display:none">
            <div class="wpfb_logic_elem">
                <span>Comment</span><select name="wpfb_condition[placeholder][]">
                    <option value="1">is equal to</option>
                    <option value="2">contains</option>
                    <option value="3">match any</option>
					<option value="4">match all</option>
                    <option value="5">if tagged people more than or equal to</option>
                </select><input type="text" name="wpfb_condition_value[placeholder][]" value="" /><a class="button button-secondary wpfb_logic_remove">Remove</a><br>
                <i class="fb_condition_description"></i><br>
                Or
            </div>
        </div>
        <br>
        <a class="button button-secondary wpfb_condition_add" style="display:none">Add New</a>
    </div>
    <div class="wpfb_reply_comment_area">
        <p>Reply Content:</p>
        <textarea name="wpfb_reply_text[placeholder]"></textarea>
        <span>[sender_name], [sender_comment]</span>
    </div>
</div>