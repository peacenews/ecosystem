<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<section id="admin-content">
    <div class="row admin-title">
        <div class="large-12 columns">
            <h2 class="bold">Edit Document</h2>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <?php edit_document($_GET['edit_doc']) ?>
            <h2>Revisions</h2>
            <table >
                <tr>
                    <th>Title</th>
                    <th>Last updated</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                <?php get_revisions($_GET['edit_doc']) ?>
            </table>

            <div class="">
                <a href="/document_sharing" class="button green">Go back</a>
            </div>
        </div>
    </div>
</section>
