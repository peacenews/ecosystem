<?
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

ini_set('display_errors', 1);

if (isset($_GET[delete_user])){
  delete_user($_GET[delete_user]);
}
if (isset($_GET[approve_user])){
  $rnd_pass=approve_user($_GET[approve_user]);
  echo md5($rnd_pass);
  send_approval_email($_GET[approve_user],$rnd_pass);
}
if (isset($_POST[update_email])){
  update_email($_POST[update_email],$_POST[app_subject],$_POST[app_content]);
}

echo '<h1>New users</h1>';
?>
<script>
    function NewSignUPCntl($scope, $http) {
        //$scope.url = '/data.php'; // The url of our search
        $scope.dname = 'delete';
        $scope.aname = 'approve and send email';
        $scope.deleted = function(did) {
            $scope.dname = 'deleted';
            $http.post("/data.php", {"delete_user": did})
            .success(function(data, status, headers, config) {
                $scope.result = data;
            }).error(function(data, status, headers, config) {
                $scope.result = status;
            });
        };
        $scope.approve = function(did) {
            $scope.aname = 'approved';
            $http.post("/data.php", {"approve_user": did})
            .success(function(data, status, headers, config) {
                $scope.result = data;
            }).error(function(data, status, headers, config) {
                $scope.result = status;
            });
        };
    }
</script>
<div  ng-controller="NewSignUPCntl">
<pre ng-model="result" style="color: black;">
{{result}}
</pre>
<?
echo '<table class="control">
  <tr>
    <th>Name</th>
    <th>email</th>
    <th>Reason for joining</th>
    <th>Delete</th>
    <th>Approve</th>
  </tr>';

    $query = "SELECT * FROM `users` WHERE `valid`='No' AND `type`='Superuser'  ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<tr>
        <td>'.$r[name].'</td>
        <td>'.$r[email].'</td>
        <td>'.$r[why].'</td>
        <td class="delete"><a href="#" ng-click="deleted('.$r[id].')">{{dname}}</a></td>
        <td class="approve"><a href="#" ng-click="approve('.$r[id].')">{{aname}}</a></td>
        </tr>';
    }
    echo '</table>';

    $query = "SELECT * FROM `emails` WHERE name='approval'  ";
        $result = $dbpdo->query($query);
        while($r = $result->fetch(PDO::FETCH_BOTH)) {
            $app_subject = $r[subject];
            $app_message= $r[content];
        }
?>
</div>
<h4>Update welcome email:</h4>
<form action="" method="post">
    <input name="app_subject" type="text" value="<? echo $app_subject?>" /><br />
    <textarea name="app_content" cols="" rows="" class="tinymce ta"><? echo $app_message?></textarea><br />
    <input name="update_email" type="hidden" value="approval"/>
    <input name="update" type="submit" value="Update" />
</form>
