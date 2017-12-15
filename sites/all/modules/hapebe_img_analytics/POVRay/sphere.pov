// <!--@hsv--> #<!--@cc--> (<!--@debug-->)
sphere { <0 0 0>, <!--@radius-->
	texture { 
		pigment{ color rgb<<!--@r-->, <!--@g-->, <!--@b-->> /* transmit 0.5 */ }
		finish { phong 1.0 reflection 0.00}
	}
	scale<1,1,1>  rotate<0,0,0>  translate<<!--@x-->, <!--@y-->, <!--@z-->>  
}
