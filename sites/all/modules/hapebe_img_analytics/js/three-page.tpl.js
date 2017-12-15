
var targetDiv = $("#threeTarget");
var aspectRatio = targetDiv.width()/targetDiv.height();

var scene = new THREE.Scene(); 

var clock = new THREE.Clock();

var camera = new THREE.PerspectiveCamera( 40, aspectRatio, 0.1, 1000 ); 
camera.position.y = -1.5;
camera.position.x = 0; // 0.25; // slightly above the "equator"
camera.position.z = 0.5;
camera.lookAt(new THREE.Vector3(0, 0, 0.5));

<!--@controls-->
// defines a camControls variable.

var renderer = new THREE.WebGLRenderer( {antialias:false,} ); 
renderer.setSize( targetDiv.width(), targetDiv.height() ); 
renderer.setClearColor(0x404040, 1);
targetDiv[0].appendChild( renderer.domElement );

// soft white ambient light
var light = new THREE.AmbientLight( 0x404040 ); 
scene.add( light );	

if (false) {
    // White directional light at half intensity shining from the top. 
    var directionalLight = new THREE.DirectionalLight( 0xffffff, 0.7 ); 
    directionalLight.position.set( 0, 1, 0 ); 
    scene.add( directionalLight );	

    // White directional light at low intensity shining from the front. 
    var frontLight = new THREE.DirectionalLight( 0xffffff, 0.2 ); 
    frontLight.position.set( 0, 0, 1 ); 
    scene.add( frontLight );	
}


document.ia = new function() {};
document.ia.materials = new function() {};
<!--@materials-->

document.ia.group = new THREE.Group();

var geometry = null; var o = null;
<!--@objects-->

// add labels / axes:
document.ia.labels = new THREE.Group();
document.ia.labels.position.z += 0.5;
addLabels(document.ia.labels);
// add the labels to the complete chart object group:
document.ia.group.add(document.ia.labels);


document.ia.group.rotation.y += 0.5 * Math.PI; // the axis that runs through the camera...
scene.add(document.ia.group);



stats = new Stats();
stats.domElement.style.position = 'absolute';
stats.domElement.style.top = '0px';
stats.domElement.style.zIndex = 100;
targetDiv[0].appendChild( stats.domElement );

var render = function () { 
        requestAnimationFrame( render ); 
        stats.update();

        var delta = clock.getDelta();
        
        camControls.update(delta);
    
        // document.ia.group.rotation.x += 0.01 * Math.PI; 
        // document.ia.group.rotation.y += 0.005 * Math.PI;
        // document.ia.group.rotation.z += 0.005 * Math.PI;
        
        renderer.render(scene, camera); 
}; 
render(); 


function addLabels(parent) {
    var zSize = 1;    
    var xyRadius = 0.5;

    // labels / axes:
    var paintAxes = true;
    var axisRadius = 0.001;
    var geometry = null;
    var material = new THREE.MeshBasicMaterial( { color: 0x7f7f7f } ); 

    // large belt:
    geometry = new THREE.TorusGeometry( xyRadius + axisRadius * 2, axisRadius, 6, 60, Math.PI * 5/3 ); 
    var torus = new THREE.Mesh( geometry, material ); 
    parent.add( torus );

    // small belt (light grey)
    geometry = new THREE.TorusGeometry( xyRadius / 2 + axisRadius * 2, axisRadius, 6, 60 ); 
    var torus = new THREE.Mesh( geometry, material ); 
    torus.position.z += 0.5 * 0.5 * zSize;
    parent.add( torus );

    // small belt (dark grey)
    geometry = new THREE.TorusGeometry( xyRadius / 2 + axisRadius * 2, axisRadius, 6, 60 ); 
    var torus = new THREE.Mesh( geometry, material ); 
    torus.position.z += -0.5 * 0.5 * zSize;
    parent.add( torus );

    var angles = {
        a0 : (0 / 360) * 2 * Math.PI,
        a60 : (60 / 360) * 2 * Math.PI,
        a120 : (120 / 360) * 2 * Math.PI,
        a180 : (180 / 360) * 2 * Math.PI,
        a240 : (240 / 360) * 2 * Math.PI,
        a300 : (300 / 360) * 2 * Math.PI,
    };

    var spots = {
        pwhite :  new THREE.Vector3(0, 0, zSize / -2),
        p0 : new THREE.Vector3(Math.cos(angles.a0) * xyRadius, Math.sin(angles.a0) * xyRadius, 0),
        p60 : new THREE.Vector3(Math.cos(angles.a60) * xyRadius, Math.sin(angles.a60) * xyRadius, 0),
        p120 : new THREE.Vector3(Math.cos(angles.a120) * xyRadius, Math.sin(angles.a120) * xyRadius, 0),
        p180 : new THREE.Vector3(Math.cos(angles.a180) * xyRadius, Math.sin(angles.a180) * xyRadius, 0),
        p240 : new THREE.Vector3(Math.cos(angles.a240) * xyRadius, Math.sin(angles.a240) * xyRadius, 0),
        p300 : new THREE.Vector3(Math.cos(angles.a300) * xyRadius, Math.sin(angles.a300) * xyRadius, 0),
        pblack :  new THREE.Vector3(0, 0, zSize / 2),
        // axes / basic coordinates:
        pzero : new THREE.Vector3(0, 0, 0),
        px1 : new THREE.Vector3(1, 0, 0),
        py1 : new THREE.Vector3(0, 1, 0),
        pz1 : new THREE.Vector3(0, 0, 1),
    };

    var lines = new Array();
    lines.push([spots.pwhite, spots.pblack]);
    lines.push([spots.pwhite, spots.p0]);
    lines.push([spots.pwhite, spots.p60]);
    lines.push([spots.pwhite, spots.p120]);
    lines.push([spots.pwhite, spots.p180]);
    lines.push([spots.pwhite, spots.p240]);
    lines.push([spots.pwhite, spots.p300]);
    lines.push([spots.pblack, spots.p0]);
    lines.push([spots.pblack, spots.p60]);
    lines.push([spots.pblack, spots.p120]);
    lines.push([spots.pblack, spots.p180]);
    lines.push([spots.pblack, spots.p240]);
    lines.push([spots.pblack, spots.p300]);

    var lineMaterial = new THREE.LineBasicMaterial({ color: 0x7f7f7f });

    for (var i in lines) {
        geometry = new THREE.Geometry();

        var myPoints = lines[i];
        for (var j in myPoints) {
            var p = myPoints[j];
            geometry.vertices.push( new THREE.Vector3( p.x , p.y , p.z ) );
        }
        var line = new THREE.Line( geometry, lineMaterial ); 
        parent.add( line );
    }

    if (paintAxes) {
        // x axis:
        lineMaterial = new THREE.LineBasicMaterial({ color: 0xff0000 });
        geometry = new THREE.Geometry();
        geometry.vertices.push( new THREE.Vector3( spots.pzero.x , spots.pzero.y , spots.pzero.z ) );
        geometry.vertices.push( new THREE.Vector3( spots.px1.x , spots.px1.y , spots.px1.z ) );
        var line = new THREE.Line( geometry, lineMaterial ); 
        parent.add( line );
        // y axis:
        lineMaterial = new THREE.LineBasicMaterial({ color: 0x00ff00 });
        geometry = new THREE.Geometry();
        geometry.vertices.push( new THREE.Vector3( spots.pzero.x , spots.pzero.y , spots.pzero.z ) );
        geometry.vertices.push( new THREE.Vector3( spots.py1.x , spots.py1.y , spots.py1.z ) );
        var line = new THREE.Line( geometry, lineMaterial ); 
        parent.add( line );
        // z axis:
        lineMaterial = new THREE.LineBasicMaterial({ color: 0x0000ff });
        geometry = new THREE.Geometry();
        geometry.vertices.push( new THREE.Vector3( spots.pzero.x , spots.pzero.y , spots.pzero.z ) );
        geometry.vertices.push( new THREE.Vector3( spots.pz1.x , spots.pz1.y , spots.pz1.z ) );
        var line = new THREE.Line( geometry, lineMaterial ); 
        parent.add( line );
    }

} // end function addLabels()
