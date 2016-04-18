<div>
    <h4>hello, {loginname}</h4>
    <div id="userpanelleft">
        <img src="/data/avatar.jpg" alt="Smiley face" height="42" width="42">
        <div id="userpanelbtn">
            <form method="post">
                <button name="connAgent" onclick="this.form.submit()" value="connAgent">Connect to Server</button>
            </form>
            <form method="post">
                <button name="toBuy" onclick="this.form.submit()" value="toBuy">Buy Pack</button>
            </form>
            <form method="post">
                <button name="logout" onclick="this.form.submit()" value="tologout">User Logout</button>
            </form>
        </div>
    </div>
    <div id="userpanelright">
        <h4>Team:{teamname}</h4>
        <h4>Token:{token}</h4>
    </div>

</div>
