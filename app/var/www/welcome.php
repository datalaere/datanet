    <br>
    <p> Welcome to <?php echo APP_NAME ?>.</p>
    <p>It is <?php echo date('H:i', time()), " on ", date('l, F d, Y'); ?>.</p>
    <?php if( Cookie::get('session_visit') ): ?>
    <p>Last visit: <?php echo Cookie::get('session_visit'); ?></p>
    <?php endif; ?>
    <br>
    <p>All connections are monitored and recorded.</p>
    <p>Any malicious and/or unauthorized activity is strictly forbidden.</p>
    <p>Disconnect IMMEDIATELY if you are not an authorized user!</p>
    <br>
    <p>Connect to host with "LOGIN [host] [username]@[password]".<p>