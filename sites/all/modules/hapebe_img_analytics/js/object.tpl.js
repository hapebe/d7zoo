o = new THREE.Mesh(
    new THREE.SphereGeometry( <!--@radius-->, 12, 6 ), 
    document.ia.materials.m<!--@material-->
);
o.position.set(<!--@x-->, <!--@y-->, <!--@z-->);
document.ia.group.add(o);
