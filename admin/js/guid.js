﻿function v2(){var t = "1234567890";return t[Math.floor(Math.random()*100)%t.length]+t[Math.floor(Math.random()*100)%t.length];}
function get_guid(){return v2()+v2()+"-"+v2()+v2()+"-"+v2()+v2()+"-"+v2()+v2();}