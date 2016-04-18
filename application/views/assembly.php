<?php
/*
 * Menu navbar, just an unordered list
 * style="list-style:none; "
 * style=" float:left; "
 */
?>
<div id="selection">
    <h2>Robot Pieces selection</h2>
    <h3>Top pieces selection</h3>
    <form method="post">
        <select name="selectedtop" onchange="this.form.submit()">
            <option value="" {selected}> - -</option>
            {topselection}
            <option value="{token}" {selected}>{piece}</option>
            {/topselection}
        </select>
        <!-- </form>-->
        <h3>Middle pieces selection</h3>
        <!--  <form method="post"> -->
        <select name="selectedmid" onchange="this.form.submit()">
            <option value="" {selected}> - -</option>
            {midselection}
            <option value="{token}" {selected}>{piece}</option>
            {/midselection}
        </select>
        <!-- </form>-->
        <h3>Bottom pieces selection</h3>
        <!--  <form method="post"> -->
        <select name="selectedbottom" onchange="this.form.submit()">
            <option value="" {selected}> - -</option>
            {bottomselection}
            <option value="{token}" {selected}>{piece}</option>
            {/bottomselection}
        </select>
    </form>
    <form action="" method="post">
        <button name="toSell" value="toSell" style="float:center">Sell the Bot</button>
    </form>
</div>
<div id="collectionInfo">
    <h2>Robot Output</h2>
    <!--{}-->
    <div id="topImg">
       <!-- <object data="/data/do-not-exist.png" type="image/png">-->
            <img class="botimg" src="/data/{sessionTop}.jpeg" />

    </div>
    <!--{/}-->
    <div id="midImg">

            <img class="botimg" src="/data/{sessionMid}.jpeg" />

    </div>
    <div id="bottomImg">

            <img class="botimg" src="/data/{sessionBottom}.jpeg" />

    </div>
</div>