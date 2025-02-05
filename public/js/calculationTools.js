    $(document).ready(function(){
        var CBPTrue= $("#combinedBoardPprint").hasClass("dp-block");
        var DPTrue= $("#digitPprint").hasClass("dp-block");
        var KOKTrue= $("#kokuPprint").hasClass("dp-block");
        var sizeName=$(".sizeName")
        if(CBPTrue){
            sizeName.html("模");
        }else if(DPTrue){
            sizeName.html("模");
        }else if(KOKTrue){
            sizeName.html("才");
        }else{
            sizeName.html("模");
        }
    });
    // 模數計算器(合版印刷)
    $('.CBPwidthNum ,.CBPheightNum ').on('keyup',{ maxW: 420, maxH: 297}, function(event) {
        var widthNum = $(".CBPwidthNum").val();
        var heightNum = $(".CBPheightNum").val();
        if( (widthNum != "")  &&  (heightNum != "") ){
            var wNum =parseFloat(widthNum);
            var hNum =parseFloat(heightNum);

            if( (event.data.maxW>=wNum) && (wNum>event.data.maxH)){
                if(event.data.maxH>=hNum){
                    x1 = wNum/90;
                    x1MathCeil =Math.ceil(x1);
                    y1 = hNum/54;
                    y1MathCeil =Math.ceil(y1);
                    xy1=x1MathCeil*y1MathCeil
                    // console.log("xy1="+xy1);
                    x2 = wNum/54;
                    x2MathCeil =Math.ceil(x2);
                    y2 = hNum/90;
                    y2MathCeil =Math.ceil(y2);            
                    xy2=x2MathCeil*y2MathCeil
                    // console.log("xy2="+xy2);
                    if(xy1>xy2){
                        $(".CBPresult").html(xy2);
                    }else{
                        $(".CBPresult").html(xy1);
                    }
                }else{
                    alert("合版上限(420mmX297mm)或(297mmX420mm)");                
                }
            }else if (event.data.maxH>=wNum) {
                if(event.data.maxW>=hNum){
                    x1 = wNum/90;
                    x1MathCeil =Math.ceil(x1);
                    y1 = hNum/54;
                    y1MathCeil =Math.ceil(y1);
                    xy1=x1MathCeil*y1MathCeil
                    // console.log("xy1="+xy1);
                    x2 = wNum/54;
                    x2MathCeil =Math.ceil(x2);
                    y2 = hNum/90;
                    y2MathCeil =Math.ceil(y2);            
                    xy2=x2MathCeil*y2MathCeil
                    // console.log("xy2="+xy2);
                    if(xy1>xy2){
                        $(".CBPresult").html(xy2);
                    }else{
                        $(".CBPresult").html(xy1);
                    }
                }else{
                    alert("合版上限(420mmX297mm)或(297mmX420mm)");                
                }
            }else{
                alert("合版上限(420mmX297mm)或(297mmX420mm)");
            }
        }else{
            $(".CBPresult").html("00");
        }
    });

    // 模數計算器(數位印刷)

    $('.DPwidthNum ,.DPheightNum ').on('keyup',{ maxW: 432, maxH: 303}, function(event) {
        var widthNum = $(".DPwidthNum").val();
        var heightNum = $(".DPheightNum").val();
        if( (widthNum != "")  &&  (heightNum != "") ){
            var wNum =parseFloat(widthNum);
            var hNum =parseFloat(heightNum);
            if( ( event.data.maxW>=wNum) && (wNum>event.data.maxH)){
                if(event.data.maxH>=hNum){
                    x1 = event.data.maxW/wNum;
                    x1MathCeil =Math.floor(x1); 
                    y1 = event.data.maxH/hNum;
                    y1MathCeil =Math.floor(y1);
                    xy1=x1MathCeil*y1MathCeil
                    // console.log("xy1="+xy1);
                    x2 = event.data.maxH/wNum;
                    x2MathCeil =Math.floor(x2);
                    y2 = event.data.maxW/hNum;
                    y2MathCeil =Math.floor(y2);            
                    xy2=x2MathCeil*y2MathCeil
                    // console.log("xy2="+xy2);
                    if(xy1>xy2){
                        $(".DPresult").html(xy1);
                        console.log("xy1>xy2="+xy1);
                    }else{
                        $(".DPresult").html(xy2);
                        console.log("xy2>xy1="+xy2);
                    }
                }else{
                    alert("數位印刷(432mmX303mm)或(303mmX432mm)");                
                }
            }else if (event.data.maxH>=wNum){
                if( event.data.maxW>=hNum){
                    x1 = event.data.maxW/wNum;
                    x1MathCeil =Math.floor(x1); 
                    y1 = event.data.maxH/hNum;
                    y1MathCeil =Math.floor(y1);
                    xy1=x1MathCeil*y1MathCeil
                    // console.log("xy1="+xy1);
                    x2 = event.data.maxH/wNum;
                    x2MathCeil =Math.floor(x2);
                    y2 = event.data.maxW/hNum;
                    y2MathCeil =Math.floor(y2);            
                    xy2=x2MathCeil*y2MathCeil
                    // console.log("xy2="+xy2);
                    if(xy1>xy2){
                        $(".DPresult").html(xy1);
                        console.log("xy1>xy2="+xy1);
                    }else{
                        $(".DPresult").html(xy2);
                        console.log("xy2>xy1="+xy2);
                    }
                }else{
                    alert("數位印刷(432mmX303mm)或(303mmX432mm)");                
                }
            }else{
                alert("數位印刷(432mmX303mm)或(303mmX432mm)");                
            }
        }else{
            $(".DPresult").html("00");
        }
    });
    // 才數計算器
    $('.KOKnum , .KOKwidthNum ,.KOKheightNum ').on('keyup', function() {
        var num = $(".KOKnum").val();
        var widthNum = $(".KOKwidthNum").val();
        var heightNum = $(".KOKheightNum").val();

        if( (num != "") && (widthNum != "") && (heightNum != "") ){
            var num = parseFloat(num);
            var wNum = parseFloat(widthNum);
            var hNum = parseFloat(heightNum);
            // console.log("數量"+num);
            // console.log("寬"+wNum);
            // console.log("高"+hNum);
            if(num==1){
                if(wNum>150){
                    if(hNum<60){
                        // console.log("數量1/寬>150/高<60 =>高=60");
                        hNum=60;
                        KOK=(wNum*hNum)/900;
                        KOKMathCeil =Math.ceil(KOK);
                        $(".KOKresult").html(KOKMathCeil);       
                    }else{
                        // console.log("數量1/寬>150/高>60 =>x×y÷900");
                        KOK=(wNum*hNum)/900;
                        KOKMathCeil =Math.ceil(KOK);
                        $(".KOKresult").html(KOKMathCeil);
                    }
                }else if(hNum>150){
                    if(wNum<60){
                        // console.log("數量1/高>150/寬<60 =>寬=60");
                        wNum=60;
                        KOK=(wNum*hNum)/900;
                        KOKMathCeil =Math.ceil(KOK);
                        $(".KOKresult").html(KOKMathCeil); 
                    }else{
                        // console.log("數量1/高>150/寬>60 =>x×y÷900");  
                        KOK=(wNum*hNum)/900;
                        KOKMathCeil =Math.ceil(KOK);    
                        $(".KOKresult").html(KOKMathCeil);                  
                    }
                }else{
                    // console.log("數量1/高>150/寬>150 =>x×y÷900");                        
                    KOK=(wNum*hNum)/900;
                    KOKMathCeil =Math.ceil(KOK);
                    $(".KOKresult").html(KOKMathCeil);                  
                }
            }else{
                // console.log("數量2 =>x×y÷900"); 
                KOK=(wNum*hNum)/900;
                KOKMathCeil =Math.ceil(KOK);
                $(".KOKresult").html(KOKMathCeil);
                console.log(KOKMathCeil);
            }
        }else{
            $(".KOKresult").html("00");
        }

    });