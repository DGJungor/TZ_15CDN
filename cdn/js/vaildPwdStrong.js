function CharMode(iN) {
		if (iN >= 48 && iN <= 57)
			return 1;
		if (iN >= 65 && iN <= 90)
			return 2;
		if (iN >= 97 && iN <= 122)
			return 4;
		else
			return 8;
	}

	function bitTotal(num) {
		modes = 0;
		for (i = 0; i < 4; i++) {
			if (num & 1)
				modes++;
			num >>>= 1;
		}
		return modes;
	}

	function checkStrong(sPW) {
		if (sPW.length <= 4)
			return 0;
		Modes = 0;
		for (i = 0; i < sPW.length; i++) {
			Modes |= CharMode(sPW.charCodeAt(i));
		}
		return bitTotal(Modes);
	}

	function pwStrength(pwd) {
		O_color = "#d6d3d3";
		L_color = "#ff3300";
		M_color = "#099";
		H_color = "#060";
		if (pwd == null || pwd == '') {
			Lcolor = Mcolor = Hcolor = O_color;
		} else {
			S_level = checkStrong(pwd);
			switch (S_level) {
			case 0:
				Lcolor = Mcolor = Hcolor = O_color;
			case 1:
				Lcolor = L_color;
				Mcolor = Hcolor = O_color;
				break;
			case 2:
				Lcolor = Mcolor = M_color;
				Hcolor = O_color;
				break;
			default:
				Lcolor = Mcolor = Hcolor = H_color;
			}
		}
		document.getElementById("strength_L").style.background = Lcolor;
		document.getElementById("strength_M").style.background = Mcolor;
		document.getElementById("strength_H").style.background = Hcolor;
		return;
	}

	function checkuser() {
		document.getElementById('reg').action = "";
		document.getElementById('reg').target = "_self";
		document.reg.checkname.value = 'check';
		document.getElementById('chk10').style.display = "none";
		document.getElementById('chk11').style.display = "none";
		document.getElementById('chk12').style.display = "none";
		document.getElementById('chk13').style.display = "none";
	}
	function confirmreg() {
		document.getElementById('reg').action = "";
		document.getElementById('reg').target = "_self";
		document.reg.confirmreg.value = 'confirm';
	}
	function confirm() {
		document.getElementById('reg').action = "";
		document.getElementById('reg').target = "_self";
		document.reg.addarea.value = 'yes';
	}
	function cancel22() {
		document.getElementById('selectarea').style.display = "none";
		return false;
	}
	function sla(tid) {
		if (document.getElementById('step_' + tid).style.display == "none") {
			document.getElementById('step_' + tid).style.display = "block";
		} else {
			document.getElementById('step_' + tid).style.display = "none";
		}
	}
	
	//验证密码的复杂性
	function passwordscheck(obj) {
		var pavalue = document.getElementById("password").value;
		var num = /^[1-9]*$/;
		var str = /^[A-Za-z]+$/;
		var strNum = /^[A-Za-z0-9]+$/;
		var num_sp = /^[0-9\_]+$/;
		var str_sp = /^[a-zA-Z\_]+$/;
		//var str_Num= /^[0-9a-zA-Z\_]+$/;
		if (pavalue == "") {
			return false;
		} else if (num.test(pavalue) | str.test(pavalue)) {
			document.getElementById(obj).innerHTML = "<font color='#ff3300'>弱</font>";
			return false;
		} else if (strNum.test(pavalue) | num_sp.test(pavalue) | str_sp.test(pavalue)) {
			document.getElementById(obj).innerHTML = "<font color='#099'>中</font>";
			/* f.userpwd.focus(); */
			return false;
		} else {
			document.getElementById(obj).innerHTML = "<font color='#060'>强</font>";
			/* f.userpwd.focus(); */
			return false;
		}
	}
	function passwordscheck(obj) {
		var pavalue = document.getElementById("password").value;
		var num = /^[1-9]*$/;
		var str = /^[A-Za-z]+$/;
		var strNum = /^[A-Za-z0-9]+$/;
		var num_sp = /^[0-9\_]+$/;
		var str_sp = /^[a-zA-Z\_]+$/;
		//var str_Num= /^[0-9a-zA-Z\_]+$/;
		if (pavalue == "") {
			return false;
		} else if (num.test(pavalue) | str.test(pavalue)) {
			document.getElementById(obj).innerHTML = "<font color='#ff3300'>弱</font>";
			return false;
		} else if (strNum.test(pavalue) | num_sp.test(pavalue) | str_sp.test(pavalue)) {
			document.getElementById(obj).innerHTML = "<font color='#099'>中</font>";
			/* f.userpwd.focus(); */
			return false;
		} else {
			document.getElementById(obj).innerHTML = "<font color='#060'>强</font>";
			/* f.userpwd.focus(); */
			return false;
		}
	}
		
	function checkPwd(obj) {
		var pwd1 = document.getElementById("password");
		var pwd2 = document.getElementById("password2");
		if(pwd2.value != '') {
			if(pwd1.value != pwd2.value) {
				document.getElementById(obj).innerHTML = "<font color='red'>输入的二次密码不正确哦。</font>";
				return false;
			} else {
				document.getElementById(obj).innerHTML = "";
			}
		}
		
	}
	
	function check() {
		var pwdOld = document.getElementById("oldPwd").value;
		var pwdNew = document.getElementById("password").value;
		var pwdSure = document.getElementById("password2").value;
		
		if(!pwdOld) {
			alert("请填写原始密码哦。");
			return false;	
		}
		if(!pwdNew) {
			alert("请填写新密码哦。");
			return false;	
		} else if(pwdNew.length < 6) {
			document.getElementById("nw").innerHTML = "<font color='red'>新密码不少于6位哦。</font>";
			return false;
		} else if(pwdNew.length > 20) {
			document.getElementById("nw").innerHTML = "<font color='red'>新密码不大于20位哦。</font>";
			return false;
		} else {
			document.getElementById("nw").innerHTML = "";
		}
		if(!pwdSure) {
			alert("请填写确认密码哦。");
			return false;	
		}
		if(pwdNew != pwdSure) {
			alert("二次输入密码一样哦。");
			return false;	
		}
		
		return true;
	}
	
	
	