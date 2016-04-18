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
        <option value="{piece}" {selected}>{piece}</option>
        {/topselection}
    </select>
   <!-- </form>-->
    <h3>Middle pieces selection</h3>
  <!--  <form method="post"> -->
    <select name="selectedmid" onchange="this.form.submit()">
        <option value="" {selected}> - -</option>
        {midselection}
        <option value="{piece}" {selected}>{piece}</option>
        {/midselection}
    </select>
    <!-- </form>-->
    <h3>Bottom pieces selection</h3>
    <!--  <form method="post"> -->
    <select name="selectedbottom" onchange="this.form.submit()">
        <option value="" {selected}> - -</option>
        {bottomselection}
        <option value="{piece}" {selected}>{piece}</option>
        {/bottomselection}
    </select>
    </form>
    <form action="" method="get">
        <button class="createBtn" type="reset" value="Create" style="float:center">Create</button>
        <button class="resetBtn" type="reset" value="Reset" style="float:center">Reset</button>
    </form>
</div>
<div id="collectionInfo">
    <h2>Robot Output</h2>
    <!--{}-->
    <div id="topImg">
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