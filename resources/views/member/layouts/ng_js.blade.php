            self.ck_all = function(){
				$http({
                    method: "get",
                    url: "/member/api/ck_all",
                    data: { user: self.model.user.id },
                }).success(function(data) {
                    if (data.status == '200') {
                        alert('已通知管理員');
                    } else {
                        alert(data);
                    }
                }).error(function() {

                }) //error
			}//self.ck_all