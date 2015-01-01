<form method=post action="?yemodule=<?$module_name?>">
 <p>
     <label for="user_name"><?$lang.enter_user_name?></label>
     <input type="text" name="user_name" id="user_name"/>
 </p>
 <p>
     <label for="user_password"><?$lang.enter_user_password?></label>
     <input type="password" name="user_password" id="user_password"/>
 </p>
 <p>
     <input type="hidden" name="back_page" value="<?$back_page?>"/>
     <input type="submit" value="<?$lang.button_user_login?>"/>
     <input type="reset" value="<?$lang.button_reset_form?>"/>
 </p>
</form>