<?php
/*
 * Menu navbar, just an unordered list
 * style="list-style:none; "
 * style=" float:left; "
 */
?>
<div id="selection">
    <h2>Player selection</h2>
    <form method="post">
        <select name="selectedname" onchange="this.form.submit()">
            <option value="" > - -</option>
            {playerinfo}
            <option value="{playername}" {selected}>{playername}</option>
            {/playerinfo}
        </select>
    </form>
    <h2>Trading Activity</h2>
    <table>
        <tr>
            <td>Player</td>
            <td>Series</td>
            <td>Value</td>
            <td>Datetime</td>
        </tr>
        {transaction}
        <tr>
            <td>{player}</td>
            <td>{series}</td>
            <td>{trans}</td>
            <td>{datetime}</td>
        </tr>
        {/transaction}
        <!--
        {personaltransinfo}
        <tr>
            <td>{player}</td>
            <td>{series}</td>
            <td>{trans}</td>
            <td>{datetime}</td>
        </tr>
        {/personaltransinfo}
        -->
        <!--        {transinfo}
            <tr>
                  <td>{player}</td>
                  <td>{series}</td>
                  <td>{trans}</td>
                  <td>{datetime}</td>
              </tr>
              {/transinfo}
        -->
    </table>
</div>
<div id="collectionInfo">
    <h2>Current Holding</h2>
    <table>
        <tr>
            <td>Player</td>
            <td>Quantity of Bots</td>
            <td>Quantity of Pieces</td>
        </tr>

        {ptt}
        <tr>
            <td>{playername}</td>
            <td>{totalbots}</td>
            <td>{totalpieces}</td>
        </tr>
        {/ptt}

    </table>

    <br/>
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=3>
    <br/>
    <table>
        <tr>
            <td>Player Name</td>
            <td>Number of top piece</td>
            <td>Number of middle piece</td>
            <td>Number of bottom piece</td>
        </tr>
        {tmbinfo}

        <tr>
            <td>{player}</td>
            <td>{top}</td>
            <td>{mid}</td>
            <td>{bottom}</td>
        </tr>
        {/tmbinfo}
    </table>
</div>