union {
	<!--@objects-->
	
	torus { // bounding circle in the X-Y plane
        1.0, 0.005
        texture {
            checker 
            texture {Texture_A_Dark}
            texture {Texture_A_Light}
            scale 0.2
            translate<0,0.1,0>
        }
        rotate <90, 0, 0>
    }
	
	object{ 
		AxisXYZ( 1, 1, 1, Texture_A_Dark, Texture_A_Light)
	}
	rotate <0, 0, ALPHA>
}