<?php
header("Content-type: application/json");
echo '{
    "version":"1.0.0",
    "model":"model.moc",
    "textures":[';
    if($_GET['cdn']){
        echo '"images.php?'.strval(rand()).'&cdn='.$_GET['cdn'].'"';
    }else{
        echo '"images.php?'.strval(rand()).'"';
    }
    echo '],
    "layout":{
        "center_x":0.0,
        "center_y":-0.05,
        "width":2.0
    },
    "hit_areas_custom":{
        "head_x":[-0.35, 0.6],
        "head_y":[0.19, -0.2],
        "body_x":[-0.3, -0.25],
        "body_y":[0.3, -0.9]
    },
    "motions":{
        "idle":[
            {"file":"motions/WakeUp.mtn"},
            {"file":"motions/Breath1.mtn"},
            {"file":"motions/Breath2.mtn"},
            {"file":"motions/Breath3.mtn"},
            {"file":"motions/Breath5.mtn"},
            {"file":"motions/Breath7.mtn"},
            {"file":"motions/Breath8.mtn"}
        ],
        "sleepy":[
            {"file":"motions/Sleeping.mtn"}
        ],
        "flick_head":[
            {"file":"motions/Touch Dere1.mtn"},
            {"file":"motions/Touch Dere2.mtn"},
            {"file":"motions/Touch Dere3.mtn"},
            {"file":"motions/Touch Dere4.mtn"},
            {"file":"motions/Touch Dere5.mtn"},
            {"file":"motions/Touch Dere6.mtn"}
        ],
        "tap_body":[
            {"file":"motions/Touch1.mtn"},
            {"file":"motions/Touch2.mtn"},
            {"file":"motions/Touch3.mtn"},
            {"file":"motions/Touch4.mtn"},
            {"file":"motions/Touch5.mtn"},
            {"file":"motions/Touch6.mtn"}
        ],
        "":[
            {"file":"motions/Breath1.mtn"},
            {"file":"motions/Breath2.mtn"},
            {"file":"motions/Breath3.mtn"},
            {"file":"motions/Breath4.mtn"},
            {"file":"motions/Breath5.mtn"},
            {"file":"motions/Breath6.mtn"},
            {"file":"motions/Breath7.mtn"},
            {"file":"motions/Breath8.mtn"},
            {"file":"motions/Fail.mtn"},
            {"file":"motions/Sleeping.mtn"},
            {"file":"motions/Success.mtn"},
            {"file":"motions/Sukebei1.mtn"},
            {"file":"motions/Sukebei2.mtn"},
            {"file":"motions/Sukebei3.mtn"},
            {"file":"motions/Touch Dere1.mtn"},
            {"file":"motions/Touch Dere2.mtn"},
            {"file":"motions/Touch Dere3.mtn"},
            {"file":"motions/Touch Dere4.mtn"},
            {"file":"motions/Touch Dere5.mtn"},
            {"file":"motions/Touch Dere6.mtn"},
            {"file":"motions/Touch1.mtn"},
            {"file":"motions/Touch2.mtn"},
            {"file":"motions/Touch3.mtn"},
            {"file":"motions/Touch4.mtn"},
            {"file":"motions/Touch5.mtn"},
            {"file":"motions/Touch6.mtn"},
            {"file":"motions/WakeUp.mtn"}
        ]
    }
}
';
?>