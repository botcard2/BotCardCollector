<?php
/*
 * Menu navbar, just an unordered list
 */
?>
<div>
{loginname}
{password}
</div>
<div id="gamestatus" >
    <h1>Game Status</h1>
    <h3>Round: 0</h3>
    <h3>Aware pieces</h3>
    <ul>
        {awarepieces}
        <li><a href="#">{piece}<img class="botimg" src="/data/{piece}.jpeg" /></a></li>
        {/awarepieces}
    </ul>
</div>
<div id="allplayers" >
    <h1>Players' Info</h1>
     <form method="post">
    <table >
        <tr>
           <!-- <td>Player ID</td>-->
            <td>Player Name</td>
            <td>Peanuts</td>
            <td>Equity</td>
        </tr>
        {playerinfo}
        <tr>
            <!--<td>{playerid}</td>-->
       
            <td value="{playername}" name="linkname" ><a href="Portfolio/{playername}" onclick="this.form.submit()">{playername}</a></td>
            <td>{peanuts}</td>
            <td>{total}</td>
        </tr>
        {/playerinfo}
    </table>
     </form>
    <form action="" method="get">
        <button class="resetBtn" type="reset" value="Reset" style="float:right">Reset</button>
    </form>
</div>
<!-- 
100 of  11s means 300 pieces
50 of 13s means 150 pieces
20 of 26s means 60 pieces
100 peanuts when reset round

1 pack includes 5 pieces values 10 peanuts
1 piece for 1 peanut
-->