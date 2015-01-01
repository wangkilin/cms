<?if $channels && is_array($channels)?>
    <?foreach item=channel from=$channels?>
        <a href="<?$channel.channel_link?>"><?$channel.channel_name?></a>
    <?/foreach?>
<?/if?>