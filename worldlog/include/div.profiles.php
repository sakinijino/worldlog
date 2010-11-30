<div id="profiles" class="section disappear">
  <span id="profiles.currentprofile"></span>
  我的地图: <br/>
  <div id="profiles.list"></div><!--clear when logout-->
  <br/>
  <span class="button" onclick="AddProfileDiv.show();">添加</span>
</div>

<script>
  function ProfilesDiv(){}
  
  Page.generateShowHideFunc(ProfilesDiv, $("profiles"), true);
  
  ProfilesDiv.addProfile = function(profile) {    
    $("profiles.list").appendChild(profile.getSelectSpan(true));
    $("profiles.list").appendChild(document.createElement('br'));
  }
  ProfilesDiv.generateDiv = function() {
    $("profiles.list").innerHTML = "";
    Page.currentUser.profiles.values().each(function(profile){
      ProfilesDiv.addProfile(profile);
    });
  }
  
  ProfileFactory.registerSelectListener(function(p){
    $("profiles.currentprofile").innerHTML ="";
    $("profiles.currentprofile").appendChild(document.createTextNode("当前的地图："+p.name+" "));
    var spn = document.createElement('span');
    spn.className = "link";
    spn.innerHTML = "[取消选择]";
    spn.onclick = function(){
      p.onUnSelect();
    }
    $("profiles.currentprofile").appendChild(spn);
    $("profiles.currentprofile").appendChild(document.createElement('br'));
    $("profiles.currentprofile").appendChild(document.createElement('br'));
  });
  ProfileFactory.registerUnSelectListener(function(p){
    $("profiles.currentprofile").innerHTML ="";
  });
  
  UserFactory.registerUserProfilesUpdateListener(ProfilesDiv.generateDiv);
  UserFactory.registerUserProfilesLoadListener(ProfilesDiv.generateDiv);
  UserFactory.registerLoginListener(ProfilesDiv.show);
  UserFactory.registerLogoutListener(function(){
    $("profiles.list").innerHTML = "";
    ProfilesDiv.hide();
  });
</script>