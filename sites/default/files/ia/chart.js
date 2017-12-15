
var targetDiv = $("#threeTarget");
var aspectRatio = targetDiv.width()/targetDiv.height();

var scene = new THREE.Scene(); 

var camera = new THREE.PerspectiveCamera( 75, aspectRatio, 0.1, 1000 ); 
camera.position.z = 2;

var renderer = new THREE.WebGLRenderer(); 
renderer.setSize( targetDiv.width(), targetDiv.height() ); 
$("#threeTarget")[0].appendChild( renderer.domElement );

// soft white ambient light
var light = new THREE.AmbientLight( 0x404040 ); 
scene.add( light );	

// White directional light at half intensity shining from the top. 
var directionalLight = new THREE.DirectionalLight( 0xffffff, 0.7 ); 
directionalLight.position.set( 0, 1, 0 ); 
scene.add( directionalLight );	

// White directional light at low intensity shining from the front. 
var frontLight = new THREE.DirectionalLight( 0xffffff, 0.2 ); 
frontLight.position.set( 0, 0, 1 ); 
scene.add( frontLight );	


document.ia = new function() {};
document.ia.materials = new function() {};
document.ia.materials.ma0dae5 = new THREE.MeshBasicMaterial( { color: 0xa0dae5 } ); 
document.ia.materials.m72b2bf = new THREE.MeshBasicMaterial( { color: 0x72b2bf } ); 
document.ia.materials.m000000 = new THREE.MeshBasicMaterial( { color: 0x000000 } ); 
document.ia.materials.m6ba6b2 = new THREE.MeshBasicMaterial( { color: 0x6ba6b2 } ); 
document.ia.materials.m82cad8 = new THREE.MeshBasicMaterial( { color: 0x82cad8 } ); 
document.ia.materials.m5297a5 = new THREE.MeshBasicMaterial( { color: 0x5297a5 } ); 
document.ia.materials.m59a3b2 = new THREE.MeshBasicMaterial( { color: 0x59a3b2 } ); 
document.ia.materials.m97cdd8 = new THREE.MeshBasicMaterial( { color: 0x97cdd8 } ); 
document.ia.materials.m7abecc = new THREE.MeshBasicMaterial( { color: 0x7abecc } ); 
document.ia.materials.m8ecccc = new THREE.MeshBasicMaterial( { color: 0x8ecccc } ); 
document.ia.materials.m7f2a19 = new THREE.MeshBasicMaterial( { color: 0x7f2a19 } ); 
document.ia.materials.m722616 = new THREE.MeshBasicMaterial( { color: 0x722616 } ); 
document.ia.materials.mdaf2ee = new THREE.MeshBasicMaterial( { color: 0xdaf2ee } ); 
document.ia.materials.m7f4a3f = new THREE.MeshBasicMaterial( { color: 0x7f4a3f } ); 
document.ia.materials.ma0e5e5 = new THREE.MeshBasicMaterial( { color: 0xa0e5e5 } ); 
document.ia.materials.ma9e6f2 = new THREE.MeshBasicMaterial( { color: 0xa9e6f2 } ); 
document.ia.materials.m85bfbf = new THREE.MeshBasicMaterial( { color: 0x85bfbf } ); 
document.ia.materials.m3d8999 = new THREE.MeshBasicMaterial( { color: 0x3d8999 } ); 
document.ia.materials.m4c8c99 = new THREE.MeshBasicMaterial( { color: 0x4c8c99 } ); 
document.ia.materials.mf2f2f2 = new THREE.MeshBasicMaterial( { color: 0xf2f2f2 } ); 
document.ia.materials.m235950 = new THREE.MeshBasicMaterial( { color: 0x235950 } ); 
document.ia.materials.m7f4c33 = new THREE.MeshBasicMaterial( { color: 0x7f4c33 } ); 
document.ia.materials.m164c43 = new THREE.MeshBasicMaterial( { color: 0x164c43 } ); 
document.ia.materials.m8c5146 = new THREE.MeshBasicMaterial( { color: 0x8c5146 } ); 
document.ia.materials.m2c594a = new THREE.MeshBasicMaterial( { color: 0x2c594a } ); 
document.ia.materials.m6bb2b2 = new THREE.MeshBasicMaterial( { color: 0x6bb2b2 } ); 
document.ia.materials.m66190a = new THREE.MeshBasicMaterial( { color: 0x66190a } ); 
document.ia.materials.m8c5438 = new THREE.MeshBasicMaterial( { color: 0x8c5438 } ); 
document.ia.materials.m724239 = new THREE.MeshBasicMaterial( { color: 0x724239 } ); 
document.ia.materials.m662114 = new THREE.MeshBasicMaterial( { color: 0x662114 } ); 
document.ia.materials.m336654 = new THREE.MeshBasicMaterial( { color: 0x336654 } ); 
document.ia.materials.m1a594e = new THREE.MeshBasicMaterial( { color: 0x1a594e } ); 
document.ia.materials.m1e4c3d = new THREE.MeshBasicMaterial( { color: 0x1e4c3d } ); 
document.ia.materials.m72bfbf = new THREE.MeshBasicMaterial( { color: 0x72bfbf } ); 
document.ia.materials.m030b0c = new THREE.MeshBasicMaterial( { color: 0x030b0c } ); 
document.ia.materials.m97d8d8 = new THREE.MeshBasicMaterial( { color: 0x97d8d8 } ); 
document.ia.materials.m264c3f = new THREE.MeshBasicMaterial( { color: 0x264c3f } ); 
document.ia.materials.m0f332d = new THREE.MeshBasicMaterial( { color: 0x0f332d } ); 
document.ia.materials.m66bacc = new THREE.MeshBasicMaterial( { color: 0x66bacc } ); 
document.ia.materials.m28665b = new THREE.MeshBasicMaterial( { color: 0x28665b } ); 
document.ia.materials.m89d6e5 = new THREE.MeshBasicMaterial( { color: 0x89d6e5 } ); 
document.ia.materials.m0f4c42 = new THREE.MeshBasicMaterial( { color: 0x0f4c42 } ); 
document.ia.materials.m0c3f37 = new THREE.MeshBasicMaterial( { color: 0x0c3f37 } ); 
document.ia.materials.m193f32 = new THREE.MeshBasicMaterial( { color: 0x193f32 } ); 
document.ia.materials.mdaf2ea = new THREE.MeshBasicMaterial( { color: 0xdaf2ea } ); 
document.ia.materials.m33665d = new THREE.MeshBasicMaterial( { color: 0x33665d } ); 
document.ia.materials.m995b3d = new THREE.MeshBasicMaterial( { color: 0x995b3d } ); 
document.ia.materials.m051919 = new THREE.MeshBasicMaterial( { color: 0x051919 } ); 
document.ia.materials.m133f38 = new THREE.MeshBasicMaterial( { color: 0x133f38 } ); 
document.ia.materials.m050b0c = new THREE.MeshBasicMaterial( { color: 0x050b0c } ); 
document.ia.materials.m193f39 = new THREE.MeshBasicMaterial( { color: 0x193f39 } ); 
document.ia.materials.m3d6658 = new THREE.MeshBasicMaterial( { color: 0x3d6658 } ); 
document.ia.materials.m235947 = new THREE.MeshBasicMaterial( { color: 0x235947 } ); 
document.ia.materials.m133f30 = new THREE.MeshBasicMaterial( { color: 0x133f30 } ); 
document.ia.materials.m1e4c44 = new THREE.MeshBasicMaterial( { color: 0x1e4c44 } ); 
document.ia.materials.m0b2621 = new THREE.MeshBasicMaterial( { color: 0x0b2621 } ); 
document.ia.materials.m26130f = new THREE.MeshBasicMaterial( { color: 0x26130f } ); 
document.ia.materials.m0b2626 = new THREE.MeshBasicMaterial( { color: 0x0b2626 } ); 
document.ia.materials.m0a332c = new THREE.MeshBasicMaterial( { color: 0x0a332c } ); 
document.ia.materials.madd8d8 = new THREE.MeshBasicMaterial( { color: 0xadd8d8 } ); 
document.ia.materials.m663b33 = new THREE.MeshBasicMaterial( { color: 0x663b33 } ); 
document.ia.materials.m072626 = new THREE.MeshBasicMaterial( { color: 0x072626 } ); 
document.ia.materials.m072621 = new THREE.MeshBasicMaterial( { color: 0x072621 } ); 
document.ia.materials.m14332d = new THREE.MeshBasicMaterial( { color: 0x14332d } ); 
document.ia.materials.m7f4426 = new THREE.MeshBasicMaterial( { color: 0x7f4426 } ); 
document.ia.materials.mcee5e1 = new THREE.MeshBasicMaterial( { color: 0xcee5e1 } ); 
document.ia.materials.m8ec1cc = new THREE.MeshBasicMaterial( { color: 0x8ec1cc } ); 
document.ia.materials.m447263 = new THREE.MeshBasicMaterial( { color: 0x447263 } ); 
document.ia.materials.m35594d = new THREE.MeshBasicMaterial( { color: 0x35594d } ); 
document.ia.materials.m071916 = new THREE.MeshBasicMaterial( { color: 0x071916 } ); 
document.ia.materials.m071919 = new THREE.MeshBasicMaterial( { color: 0x071919 } ); 
document.ia.materials.m591608 = new THREE.MeshBasicMaterial( { color: 0x591608 } ); 
document.ia.materials.m397269 = new THREE.MeshBasicMaterial( { color: 0x397269 } ); 
document.ia.materials.m051916 = new THREE.MeshBasicMaterial( { color: 0x051916 } ); 
document.ia.materials.m0f3327 = new THREE.MeshBasicMaterial( { color: 0x0f3327 } ); 
document.ia.materials.m723d22 = new THREE.MeshBasicMaterial( { color: 0x723d22 } ); 
document.ia.materials.m1f3f35 = new THREE.MeshBasicMaterial( { color: 0x1f3f35 } ); 
document.ia.materials.m8c2e1c = new THREE.MeshBasicMaterial( { color: 0x8c2e1c } ); 
document.ia.materials.m030c0c = new THREE.MeshBasicMaterial( { color: 0x030c0c } ); 
document.ia.materials.m2c5951 = new THREE.MeshBasicMaterial( { color: 0x2c5951 } ); 
document.ia.materials.m264c46 = new THREE.MeshBasicMaterial( { color: 0x264c46 } ); 
document.ia.materials.m020c0c = new THREE.MeshBasicMaterial( { color: 0x020c0c } ); 
document.ia.materials.m050c0c = new THREE.MeshBasicMaterial( { color: 0x050c0c } ); 
document.ia.materials.m0f2622 = new THREE.MeshBasicMaterial( { color: 0x0f2622 } ); 
document.ia.materials.m1f3f3a = new THREE.MeshBasicMaterial( { color: 0x1f3f3a } ); 
document.ia.materials.m143328 = new THREE.MeshBasicMaterial( { color: 0x143328 } ); 
document.ia.materials.m0a1916 = new THREE.MeshBasicMaterial( { color: 0x0a1916 } ); 
document.ia.materials.m63a5a5 = new THREE.MeshBasicMaterial( { color: 0x63a5a5 } ); 
document.ia.materials.mdaf2f2 = new THREE.MeshBasicMaterial( { color: 0xdaf2f2 } ); 
document.ia.materials.m0b261d = new THREE.MeshBasicMaterial( { color: 0x0b261d } ); 
document.ia.materials.mcee5dd = new THREE.MeshBasicMaterial( { color: 0xcee5dd } ); 
document.ia.materials.m721c0b = new THREE.MeshBasicMaterial( { color: 0x721c0b } ); 
document.ia.materials.m2d4c3d = new THREE.MeshBasicMaterial( { color: 0x2d4c3d } ); 
document.ia.materials.m0a3333 = new THREE.MeshBasicMaterial( { color: 0x0a3333 } ); 
document.ia.materials.m19332a = new THREE.MeshBasicMaterial( { color: 0x19332a } ); 
document.ia.materials.m164c3a = new THREE.MeshBasicMaterial( { color: 0x164c3a } ); 
document.ia.materials.m26160f = new THREE.MeshBasicMaterial( { color: 0x26160f } ); 
document.ia.materials.m252622 = new THREE.MeshBasicMaterial( { color: 0x252622 } ); 
document.ia.materials.m59b2b2 = new THREE.MeshBasicMaterial( { color: 0x59b2b2 } ); 
document.ia.materials.m6d7250 = new THREE.MeshBasicMaterial( { color: 0x6d7250 } ); 
document.ia.materials.m0c3f3f = new THREE.MeshBasicMaterial( { color: 0x0c3f3f } ); 
document.ia.materials.m2d4c42 = new THREE.MeshBasicMaterial( { color: 0x2d4c42 } ); 
document.ia.materials.m44726b = new THREE.MeshBasicMaterial( { color: 0x44726b } ); 
document.ia.materials.m66443d = new THREE.MeshBasicMaterial( { color: 0x66443d } ); 
document.ia.materials.m263f37 = new THREE.MeshBasicMaterial( { color: 0x263f37 } ); 
document.ia.materials.m19332e = new THREE.MeshBasicMaterial( { color: 0x19332e } ); 
document.ia.materials.m4c1307 = new THREE.MeshBasicMaterial( { color: 0x4c1307 } ); 
document.ia.materials.m0f3333 = new THREE.MeshBasicMaterial( { color: 0x0f3333 } ); 
document.ia.materials.m260f0b = new THREE.MeshBasicMaterial( { color: 0x260f0b } ); 
document.ia.materials.m722f22 = new THREE.MeshBasicMaterial( { color: 0x722f22 } ); 
document.ia.materials.m7cb2b2 = new THREE.MeshBasicMaterial( { color: 0x7cb2b2 } ); 
document.ia.materials.m606647 = new THREE.MeshBasicMaterial( { color: 0x606647 } ); 
document.ia.materials.m5fafbf = new THREE.MeshBasicMaterial( { color: 0x5fafbf } ); 
document.ia.materials.m727250 = new THREE.MeshBasicMaterial( { color: 0x727250 } ); 
document.ia.materials.m020b0c = new THREE.MeshBasicMaterial( { color: 0x020b0c } ); 
document.ia.materials.m060a0c = new THREE.MeshBasicMaterial( { color: 0x060a0c } ); 
document.ia.materials.m591d11 = new THREE.MeshBasicMaterial( { color: 0x591d11 } ); 
document.ia.materials.ma3cccc = new THREE.MeshBasicMaterial( { color: 0xa3cccc } ); 
document.ia.materials.m0a1919 = new THREE.MeshBasicMaterial( { color: 0x0a1919 } ); 
document.ia.materials.m0f261e = new THREE.MeshBasicMaterial( { color: 0x0f261e } ); 
document.ia.materials.m1f3f2f = new THREE.MeshBasicMaterial( { color: 0x1f3f2f } ); 
document.ia.materials.m5b6647 = new THREE.MeshBasicMaterial( { color: 0x5b6647 } ); 
document.ia.materials.m193326 = new THREE.MeshBasicMaterial( { color: 0x193326 } ); 
document.ia.materials.m724c44 = new THREE.MeshBasicMaterial( { color: 0x724c44 } ); 
document.ia.materials.m0a3325 = new THREE.MeshBasicMaterial( { color: 0x0a3325 } ); 
document.ia.materials.m387e8c = new THREE.MeshBasicMaterial( { color: 0x387e8c } ); 
document.ia.materials.m010c0a = new THREE.MeshBasicMaterial( { color: 0x010c0a } ); 
document.ia.materials.m52a5a5 = new THREE.MeshBasicMaterial( { color: 0x52a5a5 } ); 
document.ia.materials.m263f33 = new THREE.MeshBasicMaterial( { color: 0x263f33 } ); 
document.ia.materials.m020c0b = new THREE.MeshBasicMaterial( { color: 0x020c0b } ); 
document.ia.materials.m021919 = new THREE.MeshBasicMaterial( { color: 0x021919 } ); 
document.ia.materials.m3e5947 = new THREE.MeshBasicMaterial( { color: 0x3e5947 } ); 
document.ia.materials.m8c3a2a = new THREE.MeshBasicMaterial( { color: 0x8c3a2a } ); 
document.ia.materials.m060b0c = new THREE.MeshBasicMaterial( { color: 0x060b0c } ); 
document.ia.materials.mf2eeda = new THREE.MeshBasicMaterial( { color: 0xf2eeda } ); 
document.ia.materials.m8c5d46 = new THREE.MeshBasicMaterial( { color: 0x8c5d46 } ); 
document.ia.materials.m3f0f06 = new THREE.MeshBasicMaterial( { color: 0x3f0f06 } ); 
document.ia.materials.m133f3f = new THREE.MeshBasicMaterial( { color: 0x133f3f } ); 
document.ia.materials.m010c0c = new THREE.MeshBasicMaterial( { color: 0x010c0c } ); 
document.ia.materials.m071913 = new THREE.MeshBasicMaterial( { color: 0x071913 } ); 
document.ia.materials.m2d4c38 = new THREE.MeshBasicMaterial( { color: 0x2d4c38 } ); 
document.ia.materials.m060c0a = new THREE.MeshBasicMaterial( { color: 0x060c0a } ); 
document.ia.materials.m777f66 = new THREE.MeshBasicMaterial( { color: 0x777f66 } ); 
document.ia.materials.m5b9999 = new THREE.MeshBasicMaterial( { color: 0x5b9999 } ); 
document.ia.materials.m67725b = new THREE.MeshBasicMaterial( { color: 0x67725b } ); 
document.ia.materials.m060c0c = new THREE.MeshBasicMaterial( { color: 0x060c0c } ); 
document.ia.materials.m030c0b = new THREE.MeshBasicMaterial( { color: 0x030c0b } ); 
document.ia.materials.m2d4c47 = new THREE.MeshBasicMaterial( { color: 0x2d4c47 } ); 
document.ia.materials.m39725f = new THREE.MeshBasicMaterial( { color: 0x39725f } ); 
document.ia.materials.mb7e5e5 = new THREE.MeshBasicMaterial( { color: 0xb7e5e5 } ); 
document.ia.materials.m723516 = new THREE.MeshBasicMaterial( { color: 0x723516 } ); 
document.ia.materials.m593b35 = new THREE.MeshBasicMaterial( { color: 0x593b35 } ); 
document.ia.materials.m50593e = new THREE.MeshBasicMaterial( { color: 0x50593e } ); 
document.ia.materials.m051912 = new THREE.MeshBasicMaterial( { color: 0x051912 } ); 
document.ia.materials.m476651 = new THREE.MeshBasicMaterial( { color: 0x476651 } ); 
document.ia.materials.m7f3526 = new THREE.MeshBasicMaterial( { color: 0x7f3526 } ); 
document.ia.materials.ma56342 = new THREE.MeshBasicMaterial( { color: 0xa56342 } ); 
document.ia.materials.m13261f = new THREE.MeshBasicMaterial( { color: 0x13261f } ); 
document.ia.materials.m468c8c = new THREE.MeshBasicMaterial( { color: 0x468c8c } ); 
document.ia.materials.m1e332c = new THREE.MeshBasicMaterial( { color: 0x1e332c } ); 
document.ia.materials.m0f2626 = new THREE.MeshBasicMaterial( { color: 0x0f2626 } ); 
document.ia.materials.m355953 = new THREE.MeshBasicMaterial( { color: 0x355953 } ); 
document.ia.materials.mdaf2e6 = new THREE.MeshBasicMaterial( { color: 0xdaf2e6 } ); 
document.ia.materials.m476656 = new THREE.MeshBasicMaterial( { color: 0x476656 } ); 
document.ia.materials.m7f553f = new THREE.MeshBasicMaterial( { color: 0x7f553f } ); 
document.ia.materials.m828c70 = new THREE.MeshBasicMaterial( { color: 0x828c70 } ); 
document.ia.materials.m072126 = new THREE.MeshBasicMaterial( { color: 0x072126 } ); 
document.ia.materials.m677250 = new THREE.MeshBasicMaterial( { color: 0x677250 } ); 
document.ia.materials.m4c9999 = new THREE.MeshBasicMaterial( { color: 0x4c9999 } ); 
document.ia.materials.m72442d = new THREE.MeshBasicMaterial( { color: 0x72442d } ); 
document.ia.materials.m1e3328 = new THREE.MeshBasicMaterial( { color: 0x1e3328 } ); 
document.ia.materials.m190a07 = new THREE.MeshBasicMaterial( { color: 0x190a07 } ); 
document.ia.materials.m050c0a = new THREE.MeshBasicMaterial( { color: 0x050c0a } ); 
document.ia.materials.m507267 = new THREE.MeshBasicMaterial( { color: 0x507267 } ); 
document.ia.materials.m190c0a = new THREE.MeshBasicMaterial( { color: 0x190c0a } ); 
document.ia.materials.m3d665f = new THREE.MeshBasicMaterial( { color: 0x3d665f } ); 
document.ia.materials.m354c41 = new THREE.MeshBasicMaterial( { color: 0x354c41 } ); 
document.ia.materials.m286666 = new THREE.MeshBasicMaterial( { color: 0x286666 } ); 
document.ia.materials.m355947 = new THREE.MeshBasicMaterial( { color: 0x355947 } ); 
document.ia.materials.m4b593e = new THREE.MeshBasicMaterial( { color: 0x4b593e } ); 
document.ia.materials.ma56e52 = new THREE.MeshBasicMaterial( { color: 0xa56e52 } ); 
document.ia.materials.m0f261a = new THREE.MeshBasicMaterial( { color: 0x0f261a } ); 
document.ia.materials.m3f7f7f = new THREE.MeshBasicMaterial( { color: 0x3f7f7f } ); 
document.ia.materials.m5b6651 = new THREE.MeshBasicMaterial( { color: 0x5b6651 } ); 
document.ia.materials.m261613 = new THREE.MeshBasicMaterial( { color: 0x261613 } ); 
document.ia.materials.m263f3b = new THREE.MeshBasicMaterial( { color: 0x263f3b } ); 
document.ia.materials.m071619 = new THREE.MeshBasicMaterial( { color: 0x071619 } ); 
document.ia.materials.m063f36 = new THREE.MeshBasicMaterial( { color: 0x063f36 } ); 
document.ia.materials.m388c8c = new THREE.MeshBasicMaterial( { color: 0x388c8c } ); 
document.ia.materials.m414c35 = new THREE.MeshBasicMaterial( { color: 0x414c35 } ); 
document.ia.materials.m3e594b = new THREE.MeshBasicMaterial( { color: 0x3e594b } ); 
document.ia.materials.m6b725b = new THREE.MeshBasicMaterial( { color: 0x6b725b } ); 
document.ia.materials.m193f3f = new THREE.MeshBasicMaterial( { color: 0x193f3f } ); 
document.ia.materials.m07261c = new THREE.MeshBasicMaterial( { color: 0x07261c } ); 
document.ia.materials.m93997a = new THREE.MeshBasicMaterial( { color: 0x93997a } ); 
document.ia.materials.m286651 = new THREE.MeshBasicMaterial( { color: 0x286651 } ); 
document.ia.materials.m143333 = new THREE.MeshBasicMaterial( { color: 0x143333 } ); 
document.ia.materials.m4295a5 = new THREE.MeshBasicMaterial( { color: 0x4295a5 } ); 
document.ia.materials.m0c1917 = new THREE.MeshBasicMaterial( { color: 0x0c1917 } ); 
document.ia.materials.m264c39 = new THREE.MeshBasicMaterial( { color: 0x264c39 } ); 
document.ia.materials.m4c7f76 = new THREE.MeshBasicMaterial( { color: 0x4c7f76 } ); 
document.ia.materials.m0a1914 = new THREE.MeshBasicMaterial( { color: 0x0a1914 } ); 
document.ia.materials.m1a5959 = new THREE.MeshBasicMaterial( { color: 0x1a5959 } ); 
document.ia.materials.m132623 = new THREE.MeshBasicMaterial( { color: 0x132623 } ); 
document.ia.materials.m47665b = new THREE.MeshBasicMaterial( { color: 0x47665b } ); 
document.ia.materials.madd8d1 = new THREE.MeshBasicMaterial( { color: 0xadd8d1 } ); 
document.ia.materials.m7f3f33 = new THREE.MeshBasicMaterial( { color: 0x7f3f33 } ); 
document.ia.materials.m797f59 = new THREE.MeshBasicMaterial( { color: 0x797f59 } ); 
document.ia.materials.m4c190f = new THREE.MeshBasicMaterial( { color: 0x4c190f } ); 
document.ia.materials.m355941 = new THREE.MeshBasicMaterial( { color: 0x355941 } ); 
document.ia.materials.m051619 = new THREE.MeshBasicMaterial( { color: 0x051619 } ); 
document.ia.materials.m666647 = new THREE.MeshBasicMaterial( { color: 0x666647 } ); 
document.ia.materials.m13261c = new THREE.MeshBasicMaterial( { color: 0x13261c } ); 
document.ia.materials.m662f14 = new THREE.MeshBasicMaterial( { color: 0x662f14 } ); 
document.ia.materials.m7b7f66 = new THREE.MeshBasicMaterial( { color: 0x7b7f66 } ); 
document.ia.materials.m050a0c = new THREE.MeshBasicMaterial( { color: 0x050a0c } ); 
document.ia.materials.m164c4c = new THREE.MeshBasicMaterial( { color: 0x164c4c } ); 
document.ia.materials.m021915 = new THREE.MeshBasicMaterial( { color: 0x021915 } ); 
document.ia.materials.m878c70 = new THREE.MeshBasicMaterial( { color: 0x878c70 } ); 
document.ia.materials.m3e5950 = new THREE.MeshBasicMaterial( { color: 0x3e5950 } ); 
document.ia.materials.ma3ccc5 = new THREE.MeshBasicMaterial( { color: 0xa3ccc5 } ); 
document.ia.materials.m4c7f6e = new THREE.MeshBasicMaterial( { color: 0x4c7f6e } ); 
document.ia.materials.m63725b = new THREE.MeshBasicMaterial( { color: 0x63725b } ); 
document.ia.materials.mf2f2da = new THREE.MeshBasicMaterial( { color: 0xf2f2da } ); 
document.ia.materials.m586651 = new THREE.MeshBasicMaterial( { color: 0x586651 } ); 
document.ia.materials.m261913 = new THREE.MeshBasicMaterial( { color: 0x261913 } ); 
document.ia.materials.m662a1e = new THREE.MeshBasicMaterial( { color: 0x662a1e } ); 
document.ia.materials.m2c3f36 = new THREE.MeshBasicMaterial( { color: 0x2c3f36 } ); 
document.ia.materials.m2d7272 = new THREE.MeshBasicMaterial( { color: 0x2d7272 } ); 
document.ia.materials.m7acccc = new THREE.MeshBasicMaterial( { color: 0x7acccc } ); 
document.ia.materials.m3f150c = new THREE.MeshBasicMaterial( { color: 0x3f150c } ); 
document.ia.materials.m050c0b = new THREE.MeshBasicMaterial( { color: 0x050c0b } ); 
document.ia.materials.mc3d8d5 = new THREE.MeshBasicMaterial( { color: 0xc3d8d5 } ); 
document.ia.materials.m727f66 = new THREE.MeshBasicMaterial( { color: 0x727f66 } ); 
document.ia.materials.m2c5942 = new THREE.MeshBasicMaterial( { color: 0x2c5942 } ); 
document.ia.materials.m397272 = new THREE.MeshBasicMaterial( { color: 0x397272 } ); 
document.ia.materials.m030c08 = new THREE.MeshBasicMaterial( { color: 0x030c08 } ); 
document.ia.materials.m3d4c35 = new THREE.MeshBasicMaterial( { color: 0x3d4c35 } ); 
document.ia.materials.m597f72 = new THREE.MeshBasicMaterial( { color: 0x597f72 } ); 
document.ia.materials.m032620 = new THREE.MeshBasicMaterial( { color: 0x032620 } ); 
document.ia.materials.m66361e = new THREE.MeshBasicMaterial( { color: 0x66361e } ); 
document.ia.materials.m7f7f59 = new THREE.MeshBasicMaterial( { color: 0x7f7f59 } ); 
document.ia.materials.m47593e = new THREE.MeshBasicMaterial( { color: 0x47593e } ); 
document.ia.materials.ma0a584 = new THREE.MeshBasicMaterial( { color: 0xa0a584 } ); 
document.ia.materials.m05332b = new THREE.MeshBasicMaterial( { color: 0x05332b } ); 
document.ia.materials.m1e261f = new THREE.MeshBasicMaterial( { color: 0x1e261f } ); 
document.ia.materials.m0a1911 = new THREE.MeshBasicMaterial( { color: 0x0a1911 } ); 
document.ia.materials.m8c4a2a = new THREE.MeshBasicMaterial( { color: 0x8c4a2a } ); 
document.ia.materials.m070c0b = new THREE.MeshBasicMaterial( { color: 0x070c0b } ); 
document.ia.materials.mcee5e5 = new THREE.MeshBasicMaterial( { color: 0xcee5e5 } ); 
document.ia.materials.m0c1915 = new THREE.MeshBasicMaterial( { color: 0x0c1915 } ); 
document.ia.materials.m59342c = new THREE.MeshBasicMaterial( { color: 0x59342c } ); 
document.ia.materials.m143323 = new THREE.MeshBasicMaterial( { color: 0x143323 } ); 
document.ia.materials.m354c3d = new THREE.MeshBasicMaterial( { color: 0x354c3d } ); 
document.ia.materials.m7f554c = new THREE.MeshBasicMaterial( { color: 0x7f554c } ); 
document.ia.materials.m724c39 = new THREE.MeshBasicMaterial( { color: 0x724c39 } ); 
document.ia.materials.m010c08 = new THREE.MeshBasicMaterial( { color: 0x010c08 } ); 
document.ia.materials.m354c44 = new THREE.MeshBasicMaterial( { color: 0x354c44 } ); 
document.ia.materials.m8c411c = new THREE.MeshBasicMaterial( { color: 0x8c411c } ); 
document.ia.materials.m050c08 = new THREE.MeshBasicMaterial( { color: 0x050c08 } ); 
document.ia.materials.m2c3f39 = new THREE.MeshBasicMaterial( { color: 0x2c3f39 } ); 
document.ia.materials.m99664c = new THREE.MeshBasicMaterial( { color: 0x99664c } ); 
document.ia.materials.m1e4c4c = new THREE.MeshBasicMaterial( { color: 0x1e4c4c } ); 
document.ia.materials.m330c05 = new THREE.MeshBasicMaterial( { color: 0x330c05 } ); 
document.ia.materials.m336666 = new THREE.MeshBasicMaterial( { color: 0x336666 } ); 
document.ia.materials.m1e2426 = new THREE.MeshBasicMaterial( { color: 0x1e2426 } ); 
document.ia.materials.m8eb2ac = new THREE.MeshBasicMaterial( { color: 0x8eb2ac } ); 
document.ia.materials.m032626 = new THREE.MeshBasicMaterial( { color: 0x032626 } ); 
document.ia.materials.m233328 = new THREE.MeshBasicMaterial( { color: 0x233328 } ); 
document.ia.materials.m0b2126 = new THREE.MeshBasicMaterial( { color: 0x0b2126 } ); 
document.ia.materials.m0f4c4c = new THREE.MeshBasicMaterial( { color: 0x0f4c4c } ); 
document.ia.materials.m424c2d = new THREE.MeshBasicMaterial( { color: 0x424c2d } ); 
document.ia.materials.m3d6651 = new THREE.MeshBasicMaterial( { color: 0x3d6651 } ); 
document.ia.materials.ma5a584 = new THREE.MeshBasicMaterial( { color: 0xa5a584 } ); 
document.ia.materials.m010a0c = new THREE.MeshBasicMaterial( { color: 0x010a0c } ); 
document.ia.materials.m8e997a = new THREE.MeshBasicMaterial( { color: 0x8e997a } ); 
document.ia.materials.m111916 = new THREE.MeshBasicMaterial( { color: 0x111916 } ); 
document.ia.materials.m7f7f66 = new THREE.MeshBasicMaterial( { color: 0x7f7f66 } ); 
document.ia.materials.m0c3f2e = new THREE.MeshBasicMaterial( { color: 0x0c3f2e } ); 
document.ia.materials.m85b5bf = new THREE.MeshBasicMaterial( { color: 0x85b5bf } ); 
document.ia.materials.m115959 = new THREE.MeshBasicMaterial( { color: 0x115959 } ); 
document.ia.materials.m66280a = new THREE.MeshBasicMaterial( { color: 0x66280a } ); 
document.ia.materials.m8c4638 = new THREE.MeshBasicMaterial( { color: 0x8c4638 } ); 
document.ia.materials.m33100a = new THREE.MeshBasicMaterial( { color: 0x33100a } ); 
document.ia.materials.m2c3f33 = new THREE.MeshBasicMaterial( { color: 0x2c3f33 } ); 
document.ia.materials.m99bfb8 = new THREE.MeshBasicMaterial( { color: 0x99bfb8 } ); 
document.ia.materials.m1e331e = new THREE.MeshBasicMaterial( { color: 0x1e331e } ); 
document.ia.materials.m663328 = new THREE.MeshBasicMaterial( { color: 0x663328 } ); 
document.ia.materials.m47664c = new THREE.MeshBasicMaterial( { color: 0x47664c } ); 
document.ia.materials.m0a1619 = new THREE.MeshBasicMaterial( { color: 0x0a1619 } ); 
document.ia.materials.m020c07 = new THREE.MeshBasicMaterial( { color: 0x020c07 } ); 
document.ia.materials.m235959 = new THREE.MeshBasicMaterial( { color: 0x235959 } ); 
document.ia.materials.m0c1919 = new THREE.MeshBasicMaterial( { color: 0x0c1919 } ); 
document.ia.materials.m193f2c = new THREE.MeshBasicMaterial( { color: 0x193f2c } ); 
document.ia.materials.m74a5a5 = new THREE.MeshBasicMaterial( { color: 0x74a5a5 } ); 
document.ia.materials.madd1d8 = new THREE.MeshBasicMaterial( { color: 0xadd1d8 } ); 
document.ia.materials.mc1f2f2 = new THREE.MeshBasicMaterial( { color: 0xc1f2f2 } ); 
document.ia.materials.m3d4c2d = new THREE.MeshBasicMaterial( { color: 0x3d4c2d } ); 
document.ia.materials.m23332b = new THREE.MeshBasicMaterial( { color: 0x23332b } ); 
document.ia.materials.m727f59 = new THREE.MeshBasicMaterial( { color: 0x727f59 } ); 
document.ia.materials.m053333 = new THREE.MeshBasicMaterial( { color: 0x053333 } ); 
document.ia.materials.m597f79 = new THREE.MeshBasicMaterial( { color: 0x597f79 } ); 
document.ia.materials.m4d5935 = new THREE.MeshBasicMaterial( { color: 0x4d5935 } ); 
document.ia.materials.m080c0b = new THREE.MeshBasicMaterial( { color: 0x080c0b } ); 
document.ia.materials.m628c85 = new THREE.MeshBasicMaterial( { color: 0x628c85 } ); 
document.ia.materials.m7f5f3f = new THREE.MeshBasicMaterial( { color: 0x7f5f3f } ); 
document.ia.materials.m16261e = new THREE.MeshBasicMaterial( { color: 0x16261e } ); 
document.ia.materials.m2c5959 = new THREE.MeshBasicMaterial( { color: 0x2c5959 } ); 
document.ia.materials.m190f0a = new THREE.MeshBasicMaterial( { color: 0x190f0a } ); 
document.ia.materials.m0c1913 = new THREE.MeshBasicMaterial( { color: 0x0c1913 } ); 
document.ia.materials.md8caad = new THREE.MeshBasicMaterial( { color: 0xd8caad } ); 
document.ia.materials.m1e332f = new THREE.MeshBasicMaterial( { color: 0x1e332f } ); 
document.ia.materials.m84a5a0 = new THREE.MeshBasicMaterial( { color: 0x84a5a0 } ); 
document.ia.materials.m7f7959 = new THREE.MeshBasicMaterial( { color: 0x7f7959 } ); 
document.ia.materials.m4c332d = new THREE.MeshBasicMaterial( { color: 0x4c332d } ); 
document.ia.materials.m726d50 = new THREE.MeshBasicMaterial( { color: 0x726d50 } ); 
document.ia.materials.m54593e = new THREE.MeshBasicMaterial( { color: 0x54593e } ); 
document.ia.materials.m071910 = new THREE.MeshBasicMaterial( { color: 0x071910 } ); 
document.ia.materials.m7f3b19 = new THREE.MeshBasicMaterial( { color: 0x7f3b19 } ); 
document.ia.materials.m060c09 = new THREE.MeshBasicMaterial( { color: 0x060c09 } ); 
document.ia.materials.m263f2e = new THREE.MeshBasicMaterial( { color: 0x263f2e } ); 
document.ia.materials.m566647 = new THREE.MeshBasicMaterial( { color: 0x566647 } ); 
document.ia.materials.m628c7e = new THREE.MeshBasicMaterial( { color: 0x628c7e } ); 
document.ia.materials.m261c16 = new THREE.MeshBasicMaterial( { color: 0x261c16 } ); 
document.ia.materials.m11594d = new THREE.MeshBasicMaterial( { color: 0x11594d } ); 
document.ia.materials.m030c09 = new THREE.MeshBasicMaterial( { color: 0x030c09 } ); 
document.ia.materials.m262626 = new THREE.MeshBasicMaterial( { color: 0x262626 } ); 
document.ia.materials.m1e3325 = new THREE.MeshBasicMaterial( { color: 0x1e3325 } ); 
document.ia.materials.m8c6946 = new THREE.MeshBasicMaterial( { color: 0x8c6946 } ); 
document.ia.materials.m50726d = new THREE.MeshBasicMaterial( { color: 0x50726d } ); 
document.ia.materials.m0b2618 = new THREE.MeshBasicMaterial( { color: 0x0b2618 } ); 
document.ia.materials.m858c62 = new THREE.MeshBasicMaterial( { color: 0x858c62 } ); 
document.ia.materials.m1a5944 = new THREE.MeshBasicMaterial( { color: 0x1a5944 } ); 
document.ia.materials.m4d5947 = new THREE.MeshBasicMaterial( { color: 0x4d5947 } ); 
document.ia.materials.m4c7f7f = new THREE.MeshBasicMaterial( { color: 0x4c7f7f } ); 
document.ia.materials.m6e725b = new THREE.MeshBasicMaterial( { color: 0x6e725b } ); 
document.ia.materials.m1e3321 = new THREE.MeshBasicMaterial( { color: 0x1e3321 } ); 
document.ia.materials.m190d07 = new THREE.MeshBasicMaterial( { color: 0x190d07 } ); 
document.ia.materials.m333f2c = new THREE.MeshBasicMaterial( { color: 0x333f2c } ); 
document.ia.materials.m5f6651 = new THREE.MeshBasicMaterial( { color: 0x5f6651 } ); 
document.ia.materials.m7e8c70 = new THREE.MeshBasicMaterial( { color: 0x7e8c70 } ); 
document.ia.materials.m7f664c = new THREE.MeshBasicMaterial( { color: 0x7f664c } ); 
document.ia.materials.m1e6666 = new THREE.MeshBasicMaterial( { color: 0x1e6666 } ); 
document.ia.materials.m3e5942 = new THREE.MeshBasicMaterial( { color: 0x3e5942 } ); 
document.ia.materials.m020c09 = new THREE.MeshBasicMaterial( { color: 0x020c09 } ); 
document.ia.materials.m667f72 = new THREE.MeshBasicMaterial( { color: 0x667f72 } ); 
document.ia.materials.m548c8c = new THREE.MeshBasicMaterial( { color: 0x548c8c } ); 
document.ia.materials.m726344 = new THREE.MeshBasicMaterial( { color: 0x726344 } ); 
document.ia.materials.m260c07 = new THREE.MeshBasicMaterial( { color: 0x260c07 } ); 
document.ia.materials.m2e3f26 = new THREE.MeshBasicMaterial( { color: 0x2e3f26 } ); 
document.ia.materials.m193333 = new THREE.MeshBasicMaterial( { color: 0x193333 } ); 
document.ia.materials.m141917 = new THREE.MeshBasicMaterial( { color: 0x141917 } ); 
document.ia.materials.mb7e5dd = new THREE.MeshBasicMaterial( { color: 0xb7e5dd } ); 
document.ia.materials.m507261 = new THREE.MeshBasicMaterial( { color: 0x507261 } ); 
document.ia.materials.m333f33 = new THREE.MeshBasicMaterial( { color: 0x333f33 } ); 
document.ia.materials.m5b7263 = new THREE.MeshBasicMaterial( { color: 0x5b7263 } ); 
document.ia.materials.m8c7054 = new THREE.MeshBasicMaterial( { color: 0x8c7054 } ); 
document.ia.materials.m7a998e = new THREE.MeshBasicMaterial( { color: 0x7a998e } ); 
document.ia.materials.m2c3f3c = new THREE.MeshBasicMaterial( { color: 0x2c3f3c } ); 
document.ia.materials.m354c48 = new THREE.MeshBasicMaterial( { color: 0x354c48 } ); 
document.ia.materials.m074c4c = new THREE.MeshBasicMaterial( { color: 0x074c4c } ); 
document.ia.materials.m51665b = new THREE.MeshBasicMaterial( { color: 0x51665b } ); 
document.ia.materials.m070b0c = new THREE.MeshBasicMaterial( { color: 0x070b0c } ); 
document.ia.materials.m1f3f3f = new THREE.MeshBasicMaterial( { color: 0x1f3f3f } ); 
document.ia.materials.m05190f = new THREE.MeshBasicMaterial( { color: 0x05190f } ); 
document.ia.materials.m19110c = new THREE.MeshBasicMaterial( { color: 0x19110c } ); 
document.ia.materials.m264c4c = new THREE.MeshBasicMaterial( { color: 0x264c4c } ); 
document.ia.materials.m23332d = new THREE.MeshBasicMaterial( { color: 0x23332d } ); 
document.ia.materials.m516658 = new THREE.MeshBasicMaterial( { color: 0x516658 } ); 
document.ia.materials.m3f2213 = new THREE.MeshBasicMaterial( { color: 0x3f2213 } ); 
document.ia.materials.m8eb2b2 = new THREE.MeshBasicMaterial( { color: 0x8eb2b2 } ); 
document.ia.materials.m4c3935 = new THREE.MeshBasicMaterial( { color: 0x4c3935 } ); 
document.ia.materials.m1a2620 = new THREE.MeshBasicMaterial( { color: 0x1a2620 } ); 
document.ia.materials.m99997a = new THREE.MeshBasicMaterial( { color: 0x99997a } ); 
document.ia.materials.m592f1a = new THREE.MeshBasicMaterial( { color: 0x592f1a } ); 
document.ia.materials.m141915 = new THREE.MeshBasicMaterial( { color: 0x141915 } ); 
document.ia.materials.m664433 = new THREE.MeshBasicMaterial( { color: 0x664433 } ); 
document.ia.materials.m03090c = new THREE.MeshBasicMaterial( { color: 0x03090c } ); 
document.ia.materials.m332f2d = new THREE.MeshBasicMaterial( { color: 0x332f2d } ); 
document.ia.materials.m72725b = new THREE.MeshBasicMaterial( { color: 0x72725b } ); 
document.ia.materials.m3e5954 = new THREE.MeshBasicMaterial( { color: 0x3e5954 } ); 
document.ia.materials.m708c82 = new THREE.MeshBasicMaterial( { color: 0x708c82 } ); 
document.ia.materials.m74a59d = new THREE.MeshBasicMaterial( { color: 0x74a59d } ); 
document.ia.materials.m26140b = new THREE.MeshBasicMaterial( { color: 0x26140b } ); 
document.ia.materials.m535935 = new THREE.MeshBasicMaterial( { color: 0x535935 } ); 
document.ia.materials.m02090c = new THREE.MeshBasicMaterial( { color: 0x02090c } ); 
document.ia.materials.m283323 = new THREE.MeshBasicMaterial( { color: 0x283323 } ); 
document.ia.materials.m47594a = new THREE.MeshBasicMaterial( { color: 0x47594a } ); 
document.ia.materials.m190805 = new THREE.MeshBasicMaterial( { color: 0x190805 } ); 
document.ia.materials.m0f1914 = new THREE.MeshBasicMaterial( { color: 0x0f1914 } ); 
document.ia.materials.m66663d = new THREE.MeshBasicMaterial( { color: 0x66663d } ); 
document.ia.materials.m063f3f = new THREE.MeshBasicMaterial( { color: 0x063f3f } ); 
document.ia.materials.mc1f2ea = new THREE.MeshBasicMaterial( { color: 0xc1f2ea } ); 
document.ia.materials.m666651 = new THREE.MeshBasicMaterial( { color: 0x666651 } ); 
document.ia.materials.ma9f2f2 = new THREE.MeshBasicMaterial( { color: 0xa9f2f2 } ); 
document.ia.materials.m476660 = new THREE.MeshBasicMaterial( { color: 0x476660 } ); 
document.ia.materials.m132619 = new THREE.MeshBasicMaterial( { color: 0x132619 } ); 
document.ia.materials.m72392d = new THREE.MeshBasicMaterial( { color: 0x72392d } ); 
document.ia.materials.mf2eada = new THREE.MeshBasicMaterial( { color: 0xf2eada } ); 
document.ia.materials.m021911 = new THREE.MeshBasicMaterial( { color: 0x021911 } ); 
document.ia.materials.m333f26 = new THREE.MeshBasicMaterial( { color: 0x333f26 } ); 
document.ia.materials.m162621 = new THREE.MeshBasicMaterial( { color: 0x162621 } ); 
document.ia.materials.m626651 = new THREE.MeshBasicMaterial( { color: 0x626651 } ); 
document.ia.materials.m99bfbf = new THREE.MeshBasicMaterial( { color: 0x99bfbf } ); 
document.ia.materials.me5d6b7 = new THREE.MeshBasicMaterial( { color: 0xe5d6b7 } ); 
document.ia.materials.m132626 = new THREE.MeshBasicMaterial( { color: 0x132626 } ); 
document.ia.materials.m394c35 = new THREE.MeshBasicMaterial( { color: 0x394c35 } ); 
document.ia.materials.m0f1916 = new THREE.MeshBasicMaterial( { color: 0x0f1916 } ); 
document.ia.materials.m337f7f = new THREE.MeshBasicMaterial( { color: 0x337f7f } ); 
document.ia.materials.m444c35 = new THREE.MeshBasicMaterial( { color: 0x444c35 } ); 
document.ia.materials.m0f3321 = new THREE.MeshBasicMaterial( { color: 0x0f3321 } ); 
document.ia.materials.mc3d8d8 = new THREE.MeshBasicMaterial( { color: 0xc3d8d8 } ); 
document.ia.materials.m447272 = new THREE.MeshBasicMaterial( { color: 0x447272 } ); 
document.ia.materials.m1a261e = new THREE.MeshBasicMaterial( { color: 0x1a261e } ); 
document.ia.materials.m8eb2a6 = new THREE.MeshBasicMaterial( { color: 0x8eb2a6 } ); 
document.ia.materials.m516651 = new THREE.MeshBasicMaterial( { color: 0x516651 } ); 
document.ia.materials.m726b44 = new THREE.MeshBasicMaterial( { color: 0x726b44 } ); 
document.ia.materials.m595935 = new THREE.MeshBasicMaterial( { color: 0x595935 } ); 
document.ia.materials.m2f3f2c = new THREE.MeshBasicMaterial( { color: 0x2f3f2c } ); 
document.ia.materials.m7cb2a9 = new THREE.MeshBasicMaterial( { color: 0x7cb2a9 } ); 
document.ia.materials.mf2eac1 = new THREE.MeshBasicMaterial( { color: 0xf2eac1 } ); 
document.ia.materials.m074c41 = new THREE.MeshBasicMaterial( { color: 0x074c41 } ); 
document.ia.materials.m333333 = new THREE.MeshBasicMaterial( { color: 0x333333 } ); 
document.ia.materials.m010c07 = new THREE.MeshBasicMaterial( { color: 0x010c07 } ); 
document.ia.materials.m535947 = new THREE.MeshBasicMaterial( { color: 0x535947 } ); 
document.ia.materials.m6b9991 = new THREE.MeshBasicMaterial( { color: 0x6b9991 } ); 
document.ia.materials.m233323 = new THREE.MeshBasicMaterial( { color: 0x233323 } ); 
document.ia.materials.m0c0c08 = new THREE.MeshBasicMaterial( { color: 0x0c0c08 } ); 
document.ia.materials.m7e8c62 = new THREE.MeshBasicMaterial( { color: 0x7e8c62 } ); 
document.ia.materials.m993f2d = new THREE.MeshBasicMaterial( { color: 0x993f2d } ); 
document.ia.materials.m99705b = new THREE.MeshBasicMaterial( { color: 0x99705b } ); 
document.ia.materials.m84a59a = new THREE.MeshBasicMaterial( { color: 0x84a59a } ); 
document.ia.materials.m0c0605 = new THREE.MeshBasicMaterial( { color: 0x0c0605 } ); 
document.ia.materials.m7f6e4c = new THREE.MeshBasicMaterial( { color: 0x7f6e4c } ); 
document.ia.materials.m667f6e = new THREE.MeshBasicMaterial( { color: 0x667f6e } ); 
document.ia.materials.m997a5b = new THREE.MeshBasicMaterial( { color: 0x997a5b } ); 
document.ia.materials.m032026 = new THREE.MeshBasicMaterial( { color: 0x032026 } ); 
document.ia.materials.m5b725f = new THREE.MeshBasicMaterial( { color: 0x5b725f } ); 
document.ia.materials.m5f725b = new THREE.MeshBasicMaterial( { color: 0x5f725b } ); 
document.ia.materials.m95a59a = new THREE.MeshBasicMaterial( { color: 0x95a59a } ); 
document.ia.materials.m546651 = new THREE.MeshBasicMaterial( { color: 0x546651 } ); 
document.ia.materials.m6b9989 = new THREE.MeshBasicMaterial( { color: 0x6b9989 } ); 
document.ia.materials.m617250 = new THREE.MeshBasicMaterial( { color: 0x617250 } ); 
document.ia.materials.m475947 = new THREE.MeshBasicMaterial( { color: 0x475947 } ); 
document.ia.materials.m3d9999 = new THREE.MeshBasicMaterial( { color: 0x3d9999 } ); 
document.ia.materials.m516647 = new THREE.MeshBasicMaterial( { color: 0x516647 } ); 
document.ia.materials.m133f29 = new THREE.MeshBasicMaterial( { color: 0x133f29 } ); 
document.ia.materials.m25331e = new THREE.MeshBasicMaterial( { color: 0x25331e } ); 
document.ia.materials.m476647 = new THREE.MeshBasicMaterial( { color: 0x476647 } ); 
document.ia.materials.m47594d = new THREE.MeshBasicMaterial( { color: 0x47594d } ); 
document.ia.materials.m424c3d = new THREE.MeshBasicMaterial( { color: 0x424c3d } ); 
document.ia.materials.m4c2c26 = new THREE.MeshBasicMaterial( { color: 0x4c2c26 } ); 
document.ia.materials.m070a0c = new THREE.MeshBasicMaterial( { color: 0x070a0c } ); 
document.ia.materials.m8c8c70 = new THREE.MeshBasicMaterial( { color: 0x8c8c70 } ); 
document.ia.materials.m111915 = new THREE.MeshBasicMaterial( { color: 0x111915 } ); 
document.ia.materials.macbfb8 = new THREE.MeshBasicMaterial( { color: 0xacbfb8 } ); 
document.ia.materials.m05080c = new THREE.MeshBasicMaterial( { color: 0x05080c } ); 
document.ia.materials.m260903 = new THREE.MeshBasicMaterial( { color: 0x260903 } ); 
document.ia.materials.m667f77 = new THREE.MeshBasicMaterial( { color: 0x667f77 } ); 
document.ia.materials.m7f5933 = new THREE.MeshBasicMaterial( { color: 0x7f5933 } ); 
document.ia.materials.m4c2816 = new THREE.MeshBasicMaterial( { color: 0x4c2816 } ); 
document.ia.materials.m262622 = new THREE.MeshBasicMaterial( { color: 0x262622 } ); 
document.ia.materials.m227272 = new THREE.MeshBasicMaterial( { color: 0x227272 } ); 
document.ia.materials.mb7dde5 = new THREE.MeshBasicMaterial( { color: 0xb7dde5 } ); 
document.ia.materials.m99916b = new THREE.MeshBasicMaterial( { color: 0x99916b } ); 
document.ia.materials.m363f2c = new THREE.MeshBasicMaterial( { color: 0x363f2c } ); 
document.ia.materials.m233326 = new THREE.MeshBasicMaterial( { color: 0x233326 } ); 
document.ia.materials.m4c1f16 = new THREE.MeshBasicMaterial( { color: 0x4c1f16 } ); 
document.ia.materials.m2c3f2f = new THREE.MeshBasicMaterial( { color: 0x2c3f2f } ); 
document.ia.materials.m3f332c = new THREE.MeshBasicMaterial( { color: 0x3f332c } ); 
document.ia.materials.m2f3328 = new THREE.MeshBasicMaterial( { color: 0x2f3328 } ); 
document.ia.materials.m33664c = new THREE.MeshBasicMaterial( { color: 0x33664c } ); 
document.ia.materials.m663d28 = new THREE.MeshBasicMaterial( { color: 0x663d28 } ); 
document.ia.materials.m111913 = new THREE.MeshBasicMaterial( { color: 0x111913 } ); 
document.ia.materials.m1a2622 = new THREE.MeshBasicMaterial( { color: 0x1a2622 } ); 
document.ia.materials.m597f6c = new THREE.MeshBasicMaterial( { color: 0x597f6c } ); 
document.ia.materials.m354c35 = new THREE.MeshBasicMaterial( { color: 0x354c35 } ); 
document.ia.materials.mb7ccc1 = new THREE.MeshBasicMaterial( { color: 0xb7ccc1 } ); 
document.ia.materials.m28332d = new THREE.MeshBasicMaterial( { color: 0x28332d } ); 
document.ia.materials.m5b725b = new THREE.MeshBasicMaterial( { color: 0x5b725b } ); 
document.ia.materials.m59593e = new THREE.MeshBasicMaterial( { color: 0x59593e } ); 
document.ia.materials.md8d1ad = new THREE.MeshBasicMaterial( { color: 0xd8d1ad } ); 
document.ia.materials.m99996b = new THREE.MeshBasicMaterial( { color: 0x99996b } ); 
document.ia.materials.m59423e = new THREE.MeshBasicMaterial( { color: 0x59423e } ); 
document.ia.materials.m070c0c = new THREE.MeshBasicMaterial( { color: 0x070c0c } ); 
document.ia.materials.m162619 = new THREE.MeshBasicMaterial( { color: 0x162619 } ); 
document.ia.materials.m505947 = new THREE.MeshBasicMaterial( { color: 0x505947 } ); 
document.ia.materials.m16261c = new THREE.MeshBasicMaterial( { color: 0x16261c } ); 
document.ia.materials.m263323 = new THREE.MeshBasicMaterial( { color: 0x263323 } ); 
document.ia.materials.m2d7267 = new THREE.MeshBasicMaterial( { color: 0x2d7267 } ); 
document.ia.materials.m5f663d = new THREE.MeshBasicMaterial( { color: 0x5f663d } ); 
document.ia.materials.m8c8c62 = new THREE.MeshBasicMaterial( { color: 0x8c8c62 } ); 
document.ia.materials.m484c35 = new THREE.MeshBasicMaterial( { color: 0x484c35 } ); 
document.ia.materials.m19130c = new THREE.MeshBasicMaterial( { color: 0x19130c } ); 
document.ia.materials.m0f1917 = new THREE.MeshBasicMaterial( { color: 0x0f1917 } ); 
document.ia.materials.m2c3f2c = new THREE.MeshBasicMaterial( { color: 0x2c3f2c } ); 
document.ia.materials.m283328 = new THREE.MeshBasicMaterial( { color: 0x283328 } ); 
document.ia.materials.m99724c = new THREE.MeshBasicMaterial( { color: 0x99724c } ); 
document.ia.materials.m0f2226 = new THREE.MeshBasicMaterial( { color: 0x0f2226 } ); 
document.ia.materials.m3e593e = new THREE.MeshBasicMaterial( { color: 0x3e593e } ); 
document.ia.materials.m0f1919 = new THREE.MeshBasicMaterial( { color: 0x0f1919 } ); 
document.ia.materials.m666047 = new THREE.MeshBasicMaterial( { color: 0x666047 } ); 
document.ia.materials.m3f7f74 = new THREE.MeshBasicMaterial( { color: 0x3f7f74 } ); 
document.ia.materials.m33150f = new THREE.MeshBasicMaterial( { color: 0x33150f } ); 
document.ia.materials.m4c382d = new THREE.MeshBasicMaterial( { color: 0x4c382d } ); 
document.ia.materials.m133f22 = new THREE.MeshBasicMaterial( { color: 0x133f22 } ); 
document.ia.materials.m132613 = new THREE.MeshBasicMaterial( { color: 0x132613 } ); 
document.ia.materials.mb2ac8e = new THREE.MeshBasicMaterial( { color: 0xb2ac8e } ); 
document.ia.materials.m91996b = new THREE.MeshBasicMaterial( { color: 0x91996b } ); 
document.ia.materials.m7f7259 = new THREE.MeshBasicMaterial( { color: 0x7f7259 } ); 
document.ia.materials.m0a0c0b = new THREE.MeshBasicMaterial( { color: 0x0a0c0b } ); 
document.ia.materials.m162616 = new THREE.MeshBasicMaterial( { color: 0x162616 } ); 
document.ia.materials.m725639 = new THREE.MeshBasicMaterial( { color: 0x725639 } ); 
document.ia.materials.mb27759 = new THREE.MeshBasicMaterial( { color: 0xb27759 } ); 
document.ia.materials.mbfbfac = new THREE.MeshBasicMaterial( { color: 0xbfbfac } ); 
document.ia.materials.m1e665a = new THREE.MeshBasicMaterial( { color: 0x1e665a } ); 
document.ia.materials.m354c39 = new THREE.MeshBasicMaterial( { color: 0x354c39 } ); 
document.ia.materials.m516654 = new THREE.MeshBasicMaterial( { color: 0x516654 } ); 
document.ia.materials.m1e4c35 = new THREE.MeshBasicMaterial( { color: 0x1e4c35 } ); 
document.ia.materials.m6b9999 = new THREE.MeshBasicMaterial( { color: 0x6b9999 } ); 
document.ia.materials.m548c82 = new THREE.MeshBasicMaterial( { color: 0x548c82 } ); 
document.ia.materials.m6e7f66 = new THREE.MeshBasicMaterial( { color: 0x6e7f66 } ); 
document.ia.materials.m1f261e = new THREE.MeshBasicMaterial( { color: 0x1f261e } ); 
document.ia.materials.m222426 = new THREE.MeshBasicMaterial( { color: 0x222426 } ); 
document.ia.materials.m03261a = new THREE.MeshBasicMaterial( { color: 0x03261a } ); 
document.ia.materials.m444c3d = new THREE.MeshBasicMaterial( { color: 0x444c3d } ); 
document.ia.materials.m708c7e = new THREE.MeshBasicMaterial( { color: 0x708c7e } ); 
document.ia.materials.ma0b2a9 = new THREE.MeshBasicMaterial( { color: 0xa0b2a9 } ); 
document.ia.materials.m51665f = new THREE.MeshBasicMaterial( { color: 0x51665f } ); 
document.ia.materials.m4c4c35 = new THREE.MeshBasicMaterial( { color: 0x4c4c35 } ); 
document.ia.materials.ma0b2ac = new THREE.MeshBasicMaterial( { color: 0xa0b2ac } ); 
document.ia.materials.m3d6666 = new THREE.MeshBasicMaterial( { color: 0x3d6666 } ); 
document.ia.materials.m19120f = new THREE.MeshBasicMaterial( { color: 0x19120f } ); 
document.ia.materials.m06363f = new THREE.MeshBasicMaterial( { color: 0x06363f } ); 
document.ia.materials.m393f2c = new THREE.MeshBasicMaterial( { color: 0x393f2c } ); 
document.ia.materials.m021519 = new THREE.MeshBasicMaterial( { color: 0x021519 } ); 
document.ia.materials.m9aa584 = new THREE.MeshBasicMaterial( { color: 0x9aa584 } ); 
document.ia.materials.m592911 = new THREE.MeshBasicMaterial( { color: 0x592911 } ); 
document.ia.materials.m222626 = new THREE.MeshBasicMaterial( { color: 0x222626 } ); 
document.ia.materials.m162623 = new THREE.MeshBasicMaterial( { color: 0x162623 } ); 
document.ia.materials.me5e5ce = new THREE.MeshBasicMaterial( { color: 0xe5e5ce } ); 
document.ia.materials.m0c1911 = new THREE.MeshBasicMaterial( { color: 0x0c1911 } ); 
document.ia.materials.mc3d8d1 = new THREE.MeshBasicMaterial( { color: 0xc3d8d1 } ); 
document.ia.materials.m132616 = new THREE.MeshBasicMaterial( { color: 0x132616 } ); 
document.ia.materials.m0c1719 = new THREE.MeshBasicMaterial( { color: 0x0c1719 } ); 
document.ia.materials.m111819 = new THREE.MeshBasicMaterial( { color: 0x111819 } ); 
document.ia.materials.m663d3d = new THREE.MeshBasicMaterial( { color: 0x663d3d } ); 
document.ia.materials.m3d4c3d = new THREE.MeshBasicMaterial( { color: 0x3d4c3d } ); 
document.ia.materials.m070c0a = new THREE.MeshBasicMaterial( { color: 0x070c0a } ); 
document.ia.materials.m8c6654 = new THREE.MeshBasicMaterial( { color: 0x8c6654 } ); 
document.ia.materials.m3b3f33 = new THREE.MeshBasicMaterial( { color: 0x3b3f33 } ); 
document.ia.materials.m0c0806 = new THREE.MeshBasicMaterial( { color: 0x0c0806 } ); 
document.ia.materials.m261e16 = new THREE.MeshBasicMaterial( { color: 0x261e16 } ); 
document.ia.materials.m373f26 = new THREE.MeshBasicMaterial( { color: 0x373f26 } ); 
document.ia.materials.m50725b = new THREE.MeshBasicMaterial( { color: 0x50725b } ); 
document.ia.materials.m332219 = new THREE.MeshBasicMaterial( { color: 0x332219 } ); 
document.ia.materials.m262422 = new THREE.MeshBasicMaterial( { color: 0x262422 } ); 
document.ia.materials.me5ddb7 = new THREE.MeshBasicMaterial( { color: 0xe5ddb7 } ); 
document.ia.materials.m1e2623 = new THREE.MeshBasicMaterial( { color: 0x1e2623 } ); 
document.ia.materials.m193322 = new THREE.MeshBasicMaterial( { color: 0x193322 } ); 
document.ia.materials.m1f3f2a = new THREE.MeshBasicMaterial( { color: 0x1f3f2a } ); 
document.ia.materials.m01080c = new THREE.MeshBasicMaterial( { color: 0x01080c } ); 
document.ia.materials.m060c0b = new THREE.MeshBasicMaterial( { color: 0x060c0b } ); 
document.ia.materials.macb28e = new THREE.MeshBasicMaterial( { color: 0xacb28e } ); 
document.ia.materials.m28331e = new THREE.MeshBasicMaterial( { color: 0x28331e } ); 
document.ia.materials.m5b7267 = new THREE.MeshBasicMaterial( { color: 0x5b7267 } ); 
document.ia.materials.m474c3d = new THREE.MeshBasicMaterial( { color: 0x474c3d } ); 
document.ia.materials.m44725b = new THREE.MeshBasicMaterial( { color: 0x44725b } ); 
document.ia.materials.m4a5947 = new THREE.MeshBasicMaterial( { color: 0x4a5947 } ); 
document.ia.materials.m3d4c42 = new THREE.MeshBasicMaterial( { color: 0x3d4c42 } ); 
document.ia.materials.m7ca9b2 = new THREE.MeshBasicMaterial( { color: 0x7ca9b2 } ); 
document.ia.materials.mc1eaf2 = new THREE.MeshBasicMaterial( { color: 0xc1eaf2 } ); 
document.ia.materials.m3c3f2c = new THREE.MeshBasicMaterial( { color: 0x3c3f2c } ); 
document.ia.materials.mcee5da = new THREE.MeshBasicMaterial( { color: 0xcee5da } ); 
document.ia.materials.m33251e = new THREE.MeshBasicMaterial( { color: 0x33251e } ); 
document.ia.materials.mb7ccc8 = new THREE.MeshBasicMaterial( { color: 0xb7ccc8 } ); 
document.ia.materials.m3f3533 = new THREE.MeshBasicMaterial( { color: 0x3f3533 } ); 
document.ia.materials.mb7ccc5 = new THREE.MeshBasicMaterial( { color: 0xb7ccc5 } ); 
document.ia.materials.m5b726e = new THREE.MeshBasicMaterial( { color: 0x5b726e } ); 
document.ia.materials.m475953 = new THREE.MeshBasicMaterial( { color: 0x475953 } ); 
document.ia.materials.m725444 = new THREE.MeshBasicMaterial( { color: 0x725444 } ); 
document.ia.materials.m58663d = new THREE.MeshBasicMaterial( { color: 0x58663d } ); 
document.ia.materials.m0f1912 = new THREE.MeshBasicMaterial( { color: 0x0f1912 } ); 
document.ia.materials.m565947 = new THREE.MeshBasicMaterial( { color: 0x565947 } ); 
document.ia.materials.m99896b = new THREE.MeshBasicMaterial( { color: 0x99896b } ); 
document.ia.materials.mf2e2c1 = new THREE.MeshBasicMaterial( { color: 0xf2e2c1 } ); 
document.ia.materials.m23593e = new THREE.MeshBasicMaterial( { color: 0x23593e } ); 
document.ia.materials.m8c8562 = new THREE.MeshBasicMaterial( { color: 0x8c8562 } ); 
document.ia.materials.macbfb2 = new THREE.MeshBasicMaterial( { color: 0xacbfb2 } ); 
document.ia.materials.m331b0f = new THREE.MeshBasicMaterial( { color: 0x331b0f } ); 
document.ia.materials.m494c3d = new THREE.MeshBasicMaterial( { color: 0x494c3d } ); 
document.ia.materials.me5e1ce = new THREE.MeshBasicMaterial( { color: 0xe5e1ce } ); 
document.ia.materials.m0a2c33 = new THREE.MeshBasicMaterial( { color: 0x0a2c33 } ); 
document.ia.materials.m3f2e26 = new THREE.MeshBasicMaterial( { color: 0x3f2e26 } ); 
document.ia.materials.m84a595 = new THREE.MeshBasicMaterial( { color: 0x84a595 } ); 
document.ia.materials.m725f39 = new THREE.MeshBasicMaterial( { color: 0x725f39 } ); 
document.ia.materials.m99bfb2 = new THREE.MeshBasicMaterial( { color: 0x99bfb2 } ); 
document.ia.materials.m161918 = new THREE.MeshBasicMaterial( { color: 0x161918 } ); 
document.ia.materials.m164c31 = new THREE.MeshBasicMaterial( { color: 0x164c31 } ); 
document.ia.materials.m0f4c38 = new THREE.MeshBasicMaterial( { color: 0x0f4c38 } ); 
document.ia.materials.m07414c = new THREE.MeshBasicMaterial( { color: 0x07414c } ); 
document.ia.materials.m727244 = new THREE.MeshBasicMaterial( { color: 0x727244 } ); 
document.ia.materials.m141916 = new THREE.MeshBasicMaterial( { color: 0x141916 } ); 
document.ia.materials.m858c7e = new THREE.MeshBasicMaterial( { color: 0x858c7e } ); 
document.ia.materials.macbfb5 = new THREE.MeshBasicMaterial( { color: 0xacbfb5 } ); 
document.ia.materials.m7f5d4c = new THREE.MeshBasicMaterial( { color: 0x7f5d4c } ); 
document.ia.materials.m89997a = new THREE.MeshBasicMaterial( { color: 0x89997a } ); 
document.ia.materials.m42a5a5 = new THREE.MeshBasicMaterial( { color: 0x42a5a5 } ); 
document.ia.materials.m8c7954 = new THREE.MeshBasicMaterial( { color: 0x8c7954 } ); 
document.ia.materials.m7f7b66 = new THREE.MeshBasicMaterial( { color: 0x7f7b66 } ); 
document.ia.materials.m3f1d0c = new THREE.MeshBasicMaterial( { color: 0x3f1d0c } ); 
document.ia.materials.m708c87 = new THREE.MeshBasicMaterial( { color: 0x708c87 } ); 
document.ia.materials.m7a9989 = new THREE.MeshBasicMaterial( { color: 0x7a9989 } ); 
document.ia.materials.m3d4c44 = new THREE.MeshBasicMaterial( { color: 0x3d4c44 } ); 
document.ia.materials.mb2b28e = new THREE.MeshBasicMaterial( { color: 0xb2b28e } ); 
document.ia.materials.m191411 = new THREE.MeshBasicMaterial( { color: 0x191411 } ); 
document.ia.materials.m333f39 = new THREE.MeshBasicMaterial( { color: 0x333f39 } ); 
document.ia.materials.m19140f = new THREE.MeshBasicMaterial( { color: 0x19140f } ); 
document.ia.materials.m8c7e62 = new THREE.MeshBasicMaterial( { color: 0x8c7e62 } ); 
document.ia.materials.m3f4c3d = new THREE.MeshBasicMaterial( { color: 0x3f4c3d } ); 
document.ia.materials.m628c8c = new THREE.MeshBasicMaterial( { color: 0x628c8c } ); 
document.ia.materials.m66583d = new THREE.MeshBasicMaterial( { color: 0x66583d } ); 
document.ia.materials.m085959 = new THREE.MeshBasicMaterial( { color: 0x085959 } ); 
document.ia.materials.m726750 = new THREE.MeshBasicMaterial( { color: 0x726750 } ); 
document.ia.materials.m28332c = new THREE.MeshBasicMaterial( { color: 0x28332c } ); 
document.ia.materials.m99321e = new THREE.MeshBasicMaterial( { color: 0x99321e } ); 
document.ia.materials.m95a59d = new THREE.MeshBasicMaterial( { color: 0x95a59d } ); 
document.ia.materials.m474c2d = new THREE.MeshBasicMaterial( { color: 0x474c2d } ); 
document.ia.materials.mccccb7 = new THREE.MeshBasicMaterial( { color: 0xccccb7 } ); 
document.ia.materials.m3f2a26 = new THREE.MeshBasicMaterial( { color: 0x3f2a26 } ); 
document.ia.materials.m190e0c = new THREE.MeshBasicMaterial( { color: 0x190e0c } ); 
document.ia.materials.m7a9993 = new THREE.MeshBasicMaterial( { color: 0x7a9993 } ); 
document.ia.materials.m664a3d = new THREE.MeshBasicMaterial( { color: 0x664a3d } ); 
document.ia.materials.m99826b = new THREE.MeshBasicMaterial( { color: 0x99826b } ); 
document.ia.materials.m313328 = new THREE.MeshBasicMaterial( { color: 0x313328 } ); 
document.ia.materials.m5b726b = new THREE.MeshBasicMaterial( { color: 0x5b726b } ); 
document.ia.materials.m899991 = new THREE.MeshBasicMaterial( { color: 0x899991 } ); 
document.ia.materials.m59251a = new THREE.MeshBasicMaterial( { color: 0x59251a } ); 
var geometry = null; var o = null;
o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.26886508707568, 8, 4 ), 
    document.ia.materials.ma0dae5
);
o.position.set(0.36705095334335, 0.765, -0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.24606868830706, 8, 4 ), 
    document.ia.materials.m72b2bf
);
o.position.set(0.35227883704817, 0.6, -0.052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.19773426640569, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.17667255585002, 8, 4 ), 
    document.ia.materials.m6ba6b2
);
o.position.set(0.36212691457829, 0.56, -0.048621489746741);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.17113356832971, 8, 4 ), 
    document.ia.materials.m82cad8
);
o.position.set(0.33258268198792, 0.68, -0.059040380406756);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.14788575402262, 8, 4 ), 
    document.ia.materials.m5297a5
);
o.position.set(0.33996874013552, 0.4875, -0.056435657741752);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.1419975450102, 8, 4 ), 
    document.ia.materials.m59a3b2
);
o.position.set(0.32765864322286, 0.525, -0.060776862183426);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.14022913796973, 8, 4 ), 
    document.ia.materials.m97cdd8
);
o.position.set(0.37443701149094, 0.7225, -0.044280285305067);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.12907238040542, 8, 4 ), 
    document.ia.materials.m7abecc
);
o.position.set(0.34243075951805, 0.64, -0.055567416853418);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.10164249712132, 8, 4 ), 
    document.ia.materials.m8ecccc
);
o.position.set(0.38, 0.68, 2.9391523179536E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.09361650191092, 8, 4 ), 
    document.ia.materials.m7f2a19
);
o.position.set(0.69696155060244, 0.3, 0.069459271066772);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.091185892232106, 8, 4 ), 
    document.ia.materials.m722616
);
o.position.set(0.6772653955422, 0.27, 0.062513343960095);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.088010808753967, 8, 4 ), 
    document.ia.materials.mdaf2ee
);
o.position.set(0.45322163173192, 0.9025, 0.016496576878358);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.087041434359978, 8, 4 ), 
    document.ia.materials.m7f4a3f
);
o.position.set(0.62310096912653, 0.375, 0.043412044416733);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.086292800775109, 8, 4 ), 
    document.ia.materials.ma0e5e5
);
o.position.set(0.365, 0.765, 3.3065463576979E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.085128202167884, 8, 4 ), 
    document.ia.materials.ma9e6f2
);
o.position.set(0.35966489519576, 0.8075, -0.049489730635075);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.082810140169227, 8, 4 ), 
    document.ia.materials.m85bfbf
);
o.position.set(0.3875, 0.6375, 2.7554552980815E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.074296390789153, 8, 4 ), 
    document.ia.materials.m3d8999
);
o.position.set(0.3227346044578, 0.42, -0.062513343960095);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.073281827135636, 8, 4 ), 
    document.ia.materials.m4c8c99
);
o.position.set(0.35227883704817, 0.45, -0.052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.07300889573252, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.072183909975257, 8, 4 ), 
    document.ia.materials.mf2f2f2
);
o.position.set(0.5, 0.95, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.069650347228269, 8, 4 ), 
    document.ia.materials.m235950
);
o.position.set(0.39659518593372, 0.245, 0.036466117310055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.06849424457571, 8, 4 ), 
    document.ia.materials.m7f4c33
);
o.position.set(0.64095389311789, 0.35, 0.1026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.066647698485406, 8, 4 ), 
    document.ia.materials.m164c43
);
o.position.set(0.39659518593372, 0.195, 0.036466117310055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.066572771313336, 8, 4 ), 
    document.ia.materials.m8c5146
);
o.position.set(0.63541106603918, 0.4125, 0.047753248858406);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.065285853890815, 8, 4 ), 
    document.ia.materials.m2c594a
);
o.position.set(0.41777689568123, 0.2625, 0.059853525081992);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.064671385123114, 8, 4 ), 
    document.ia.materials.m6bb2b2
);
o.position.set(0.36, 0.56, 3.4290110376126E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.063738575893852, 8, 4 ), 
    document.ia.materials.m66190a
);
o.position.set(0.6772653955422, 0.22, 0.062513343960095);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.06295067693312, 8, 4 ), 
    document.ia.materials.m8c5438
);
o.position.set(0.65504928242967, 0.385, 0.11286664729747);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.062632742188753, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.062473168064019, 8, 4 ), 
    document.ia.materials.m724239
);
o.position.set(0.61079087221387, 0.3375, 0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.061911419758461, 8, 4 ), 
    document.ia.materials.m662114
);
o.position.set(0.65756924048195, 0.24, 0.055567416853418);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.061830753379241, 8, 4 ), 
    document.ia.materials.m336654
);
o.position.set(0.40603073792141, 0.3, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.060936375833672, 8, 4 ), 
    document.ia.materials.m1a594e
);
o.position.set(0.379361050256, 0.2275, 0.042543803528398);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.059862158914566, 8, 4 ), 
    document.ia.materials.m1e4c3d
);
o.position.set(0.41542766412927, 0.21, 0.06156362579862);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.059275671556432, 8, 4 ), 
    document.ia.materials.m72bfbf
);
o.position.set(0.35, 0.6, 3.6739403974421E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.059191413274242, 8, 4 ), 
    document.ia.materials.m030b0c
);
o.position.set(0.48276586432229, 0.0325, -0.0060776862183426);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.059022535859403, 8, 4 ), 
    document.ia.materials.m97d8d8
);
o.position.set(0.3725, 0.7225, 3.1228493378258E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.0586833230741, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.05704452277657, 8, 4 ), 
    document.ia.materials.m264c3f
);
o.position.set(0.42952305344106, 0.225, 0.05130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.056605374422288, 8, 4 ), 
    document.ia.materials.m0f332d
);
o.position.set(0.43106345728915, 0.13, 0.02431074487337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.055895561084731, 8, 4 ), 
    document.ia.materials.mf2f2f2
);
o.position.set(0.5, 0.95, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.055176617189406, 8, 4 ), 
    document.ia.materials.m66bacc
);
o.position.set(0.30303844939756, 0.6, -0.069459271066772);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.054813609187965, 8, 4 ), 
    document.ia.materials.m28665b
);
o.position.set(0.38182306963854, 0.28, 0.041675562640063);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.054631200664852, 8, 4 ), 
    document.ia.materials.m89d6e5
);
o.position.set(0.3227346044578, 0.72, -0.062513343960095);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.054539767628947, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.053709866462737, 8, 4 ), 
    document.ia.materials.m0f4c42
);
o.position.set(0.38182306963854, 0.18, 0.041675562640063);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.053243221072039, 8, 4 ), 
    document.ia.materials.m0c3f37
);
o.position.set(0.40151922469878, 0.15, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.05229744027663, 8, 4 ), 
    document.ia.materials.m193f32
);
o.position.set(0.42952305344106, 0.175, 0.05130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.052106224132632, 8, 4 ), 
    document.ia.materials.mdaf2ea
);
o.position.set(0.45536460051267, 0.9025, 0.032491913615939);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.051625085259406, 8, 4 ), 
    document.ia.materials.m33665d
);
o.position.set(0.40151922469878, 0.3, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.051431369434551, 8, 4 ), 
    document.ia.materials.m995b3d
);
o.position.set(0.66914467174146, 0.42, 0.12312725159724);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.051236921216889, 8, 4 ), 
    document.ia.materials.m051919
);
o.position.set(0.46, 0.06, 9.7971743931788E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.050054371427676, 8, 4 ), 
    document.ia.materials.m133f38
);
o.position.set(0.41382932161143, 0.1625, 0.030388431091713);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.050054371427676, 8, 4 ), 
    document.ia.materials.m050b0c
);
o.position.set(0.48522788370482, 0.035, -0.0052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.049854552779983, 8, 4 ), 
    document.ia.materials.m193f39
);
o.position.set(0.42613941852408, 0.175, 0.02604722665004);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.04975434252232, 8, 4 ), 
    document.ia.materials.m3d6658
);
o.position.set(0.42482459033713, 0.32, 0.054723222932107);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.049148790437257, 8, 4 ), 
    document.ia.materials.m235947
);
o.position.set(0.40133227481748, 0.245, 0.07182423009839);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.049047138228255, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.048843199140248, 8, 4 ), 
    document.ia.materials.m133f30
);
o.position.set(0.41777689568123, 0.1625, 0.059853525081992);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.04874090960569, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.04874090960569, 8, 4 ), 
    document.ia.materials.m1e4c44
);
o.position.set(0.4113673022289, 0.21, 0.031256671980048);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.048122606650172, 8, 4 ), 
    document.ia.materials.m0b2621
);
o.position.set(0.44829759296686, 0.0975, 0.018233058655028);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.04791473264748, 8, 4 ), 
    document.ia.materials.m26130f
);
o.position.set(0.54431634888555, 0.105, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.047179961564553, 8, 4 ), 
    document.ia.materials.m0b2626
);
o.position.set(0.4475, 0.0975, 1.2858791391047E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.047179961564553, 8, 4 ), 
    document.ia.materials.m0a332c
);
o.position.set(0.42121537975902, 0.12, 0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.046325955022235, 8, 4 ), 
    document.ia.materials.madd8d8
);
o.position.set(0.415, 0.765, 2.0818995585505E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.046001615292625, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.04545590659322, 8, 4 ), 
    document.ia.materials.m663b33
);
o.position.set(0.59848077530122, 0.3, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044903566438451, 8, 4 ), 
    document.ia.materials.m072626
);
o.position.set(0.44, 0.09, 1.4695761589768E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044792281096508, 8, 4 ), 
    document.ia.materials.m072621
);
o.position.set(0.44091153481927, 0.09, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044792281096508, 8, 4 ), 
    document.ia.materials.m14332d
);
o.position.set(0.44091153481927, 0.14, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044680718579324, 8, 4 ), 
    document.ia.materials.m7f4426
);
o.position.set(0.66444620863753, 0.325, 0.11970705016398);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044568876805468, 8, 4 ), 
    document.ia.materials.mcee5e1
);
o.position.set(0.45568365111445, 0.855, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.044456753667324, 8, 4 ), 
    document.ia.materials.m8ec1cc
);
o.position.set(0.38182306963854, 0.68, -0.041675562640063);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.043319563894376, 8, 4 ), 
    document.ia.materials.m447263
);
o.position.set(0.41542766412927, 0.36, 0.06156362579862);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.043319563894376, 8, 4 ), 
    document.ia.materials.m35594d
);
o.position.set(0.43422151654499, 0.28, 0.047882820065594);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.043204198672526, 8, 4 ), 
    document.ia.materials.m071916
);
o.position.set(0.46553172864457, 0.065, 0.012155372436685);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.043088524572921, 8, 4 ), 
    document.ia.materials.m071919
);
o.position.set(0.465, 0.065, 8.5725275940315E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.042972539101238, 8, 4 ), 
    document.ia.materials.m591608
);
o.position.set(0.65510722109942, 0.1925, 0.054699175965083);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.042856239729397, 8, 4 ), 
    document.ia.materials.m397269
);
o.position.set(0.38920912778613, 0.3375, 0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041794985179674, 8, 4 ), 
    document.ia.materials.m051916
);
o.position.set(0.46060768987951, 0.06, 0.013891854213354);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041555470398511, 8, 4 ), 
    document.ia.materials.m0f3327
);
o.position.set(0.43422151654499, 0.13, 0.047882820065594);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041193587132587, 8, 4 ), 
    document.ia.materials.m723d22
);
o.position.set(0.64800158777378, 0.2925, 0.10773634514759);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041072250824446, 8, 4 ), 
    document.ia.materials.m1f3f35
);
o.position.set(0.44126921120088, 0.1875, 0.042752517915709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041072250824446, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.041072250824446, 8, 4 ), 
    document.ia.materials.m8c2e1c
);
o.position.set(0.71665770566269, 0.33, 0.076405198173449);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.040828496441316, 8, 4 ), 
    document.ia.materials.m030c0c
);
o.position.set(0.4825, 0.0325, 4.2862637970157E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.040212646721392, 8, 4 ), 
    document.ia.materials.m2c5951
);
o.position.set(0.41382932161143, 0.2625, 0.030388431091713);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.040088341488214, 8, 4 ), 
    document.ia.materials.m264c46
);
o.position.set(0.42613941852408, 0.225, 0.02604722665004);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.039963649610763, 8, 4 ), 
    document.ia.materials.m020c0c
);
o.position.set(0.48, 0.03, 4.8985871965894E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.039838567458532, 8, 4 ), 
    document.ia.materials.m050c0c
);
o.position.set(0.485, 0.035, 3.6739403974421E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03971309134384, 8, 4 ), 
    document.ia.materials.m0f2622
);
o.position.set(0.45568365111445, 0.105, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.039587217520563, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.039207171433666, 8, 4 ), 
    document.ia.materials.m1f3f3a
);
o.position.set(0.43844951543674, 0.1875, 0.021706022208366);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.039079668099474, 8, 4 ), 
    document.ia.materials.m143328
);
o.position.set(0.44361844275285, 0.14, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.038694637349038, 8, 4 ), 
    document.ia.materials.m0a1916
);
o.position.set(0.47045576740963, 0.07, 0.010418890660016);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.038435807438454, 8, 4 ), 
    document.ia.materials.m63a5a5
);
o.position.set(0.37, 0.52, 3.1840816777831E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.038044260989727, 8, 4 ), 
    document.ia.materials.mdaf2f2
);
o.position.set(0.4525, 0.9025, 1.16341445919E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.038044260989727, 8, 4 ), 
    document.ia.materials.m0b261d
);
o.position.set(0.45066613740874, 0.0975, 0.035912115049195);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037780975743445, 8, 4 ), 
    document.ia.materials.mcee5dd
);
o.position.set(0.45771383206463, 0.855, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037648642672253, 8, 4 ), 
    document.ia.materials.m721c0b
);
o.position.set(0.69942356998497, 0.2475, 0.070327511955107);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037648642672253, 8, 4 ), 
    document.ia.materials.m2d4c3d
);
o.position.set(0.44803847577293, 0.24, 0.06);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037515842813392, 8, 4 ), 
    document.ia.materials.m0a3333
);
o.position.set(0.42, 0.12, 1.9594348786358E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037515842813392, 8, 4 ), 
    document.ia.materials.m19332a
);
o.position.set(0.4530153689607, 0.15, 0.034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.037114592316334, 8, 4 ), 
    document.ia.materials.m164c3a
);
o.position.set(0.40133227481748, 0.195, 0.07182423009839);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.036979874658304, 8, 4 ), 
    document.ia.materials.m26160f
);
o.position.set(0.54228616793537, 0.105, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.036979874658304, 8, 4 ), 
    document.ia.materials.m252622
);
o.position.set(0.50256515107494, 0.1425, 0.014095389311789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03684466442621, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03684466442621, 8, 4 ), 
    document.ia.materials.m59b2b2
);
o.position.set(0.325, 0.525, 4.2862637970157E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.036298787368516, 8, 4 ), 
    document.ia.materials.m6d7250
);
o.position.set(0.52308635967448, 0.3825, 0.1268585038061);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.036298787368516, 8, 4 ), 
    document.ia.materials.m0c3f3f
);
o.position.set(0.4, 0.15, 2.4492935982947E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03602274695657, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035883930459654, 8, 4 ), 
    document.ia.materials.m2d4c42
);
o.position.set(0.44361844275285, 0.24, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035883930459654, 8, 4 ), 
    document.ia.materials.m44726b
);
o.position.set(0.4113673022289, 0.36, 0.031256671980048);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035744574863459, 8, 4 ), 
    document.ia.materials.m66443d
);
o.position.set(0.57878462024098, 0.32, 0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035604673837934, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035604673837934, 8, 4 ), 
    document.ia.materials.m263f37
);
o.position.set(0.4530153689607, 0.2, 0.034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035604673837934, 8, 4 ), 
    document.ia.materials.m19332e
);
o.position.set(0.45075961234939, 0.15, 0.017364817766693);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035604673837934, 8, 4 ), 
    document.ia.materials.m4c1307
);
o.position.set(0.63294904665665, 0.165, 0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035323209550917, 8, 4 ), 
    document.ia.materials.m0f3333
);
o.position.set(0.43, 0.13, 1.7145055188063E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.035323209550917, 8, 4 ), 
    document.ia.materials.m260f0b
);
o.position.set(0.55170240703314, 0.0975, 0.018233058655028);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03518163299101, 8, 4 ), 
    document.ia.materials.m722f22
);
o.position.set(0.65510722109942, 0.2925, 0.054699175965083);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03503948439761, 8, 4 ), 
    document.ia.materials.mf2f2f2
);
o.position.set(0.5, 0.95, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03503948439761, 8, 4 ), 
    document.ia.materials.m7cb2b2
);
o.position.set(0.395, 0.595, 2.5717582782094E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034896756780344, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034753443005301, 8, 4 ), 
    document.ia.materials.m606647
);
o.position.set(0.52052120859954, 0.34, 0.11276311449431);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034753443005301, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034609535790861, 8, 4 ), 
    document.ia.materials.m5fafbf
);
o.position.set(0.31534854631021, 0.5625, -0.065118066625099);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034609535790861, 8, 4 ), 
    document.ia.materials.m727250
);
o.position.set(0.53375, 0.3825, 0.1169134295109);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034609535790861, 8, 4 ), 
    document.ia.materials.m020b0c
);
o.position.set(0.48030384493976, 0.03, -0.0069459271066772);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034465027703384, 8, 4 ), 
    document.ia.materials.m060a0c
);
o.position.set(0.48825384224018, 0.0375, -0.0085505035831417);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034465027703384, 8, 4 ), 
    document.ia.materials.m591d11
);
o.position.set(0.63787308542171, 0.21, 0.04862148974674);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034465027703384, 8, 4 ), 
    document.ia.materials.ma3cccc
);
o.position.set(0.42, 0.72, 1.9594348786358E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034174178387598, 8, 4 ), 
    document.ia.materials.m0a1919
);
o.position.set(0.47, 0.07, 7.3478807948841E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034174178387598, 8, 4 ), 
    document.ia.materials.m0f261e
);
o.position.set(0.45771383206463, 0.105, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.034174178387598, 8, 4 ), 
    document.ia.materials.m1f3f2f
);
o.position.set(0.44587341226347, 0.1875, 0.0625);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033880832373774, 8, 4 ), 
    document.ia.materials.m5b6647
);
o.position.set(0.51041889066002, 0.34, 0.11817693036146);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033733202772282, 8, 4 ), 
    document.ia.materials.m193326
);
o.position.set(0.45669872981078, 0.15, 0.05);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033733202772282, 8, 4 ), 
    document.ia.materials.m724c44
);
o.position.set(0.5886326977711, 0.36, 0.031256671980047);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033733202772282, 8, 4 ), 
    document.ia.materials.m0a3325
);
o.position.set(0.42482459033713, 0.12, 0.054723222932107);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033435988143739, 8, 4 ), 
    document.ia.materials.m387e8c
);
o.position.set(0.33750672075299, 0.385, -0.057303898630087);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033435988143739, 8, 4 ), 
    document.ia.materials.m010c0a
);
o.position.set(0.47784182555723, 0.0275, 0.0078141679950119);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033286385656668, 8, 4 ), 
    document.ia.materials.m52a5a5
);
o.position.set(0.3375, 0.4875, 3.9801020972289E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033286385656668, 8, 4 ), 
    document.ia.materials.m263f33
);
o.position.set(0.45669872981078, 0.2, 0.05);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033286385656668, 8, 4 ), 
    document.ia.materials.m020c0b
);
o.position.set(0.48030384493976, 0.03, 0.0069459271066772);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.033136107753033, 8, 4 ), 
    document.ia.materials.m021919
);
o.position.set(0.455, 0.055, 1.1021821192326E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03298514520139, 8, 4 ), 
    document.ia.materials.m3e5947
);
o.position.set(0.45978266673625, 0.2975, 0.067492699017087);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03298514520139, 8, 4 ), 
    document.ia.materials.m8c3a2a
);
o.position.set(0.68957549245485, 0.3575, 0.066854548401768);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.032681128160288, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.032374256311173, 8, 4 ), 
    document.ia.materials.m060b0c
);
o.position.set(0.48768990308735, 0.0375, -0.0043412044416733);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.032374256311173, 8, 4 ), 
    document.ia.materials.mf2eeda
);
o.position.set(0.53053241146011, 0.9025, 0.072774222096303);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.032219724372466, 8, 4 ), 
    document.ia.materials.m8c5d46
);
o.position.set(0.62920773535806, 0.4125, 0.094055539414559);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.032064447688583, 8, 4 ), 
    document.ia.materials.m3f0f06
);
o.position.set(0.61079087221387, 0.1375, 0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031908415387011, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031908415387011, 8, 4 ), 
    document.ia.materials.m133f3f
);
o.position.set(0.4125, 0.1625, 2.1431318985079E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031908415387011, 8, 4 ), 
    document.ia.materials.m010c0c
);
o.position.set(0.4775, 0.0275, 5.5109105961631E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031908415387011, 8, 4 ), 
    document.ia.materials.m071913
);
o.position.set(0.46711075827249, 0.065, 0.023941410032797);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03175161632809, 8, 4 ), 
    document.ia.materials.m2d4c38
);
o.position.set(0.45403733341286, 0.24, 0.077134513162385);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03175161632809, 8, 4 ), 
    document.ia.materials.m060c0a
);
o.position.set(0.48825384224018, 0.0375, 0.0085505035831417);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031594039095728, 8, 4 ), 
    document.ia.materials.m777f66
);
o.position.set(0.50868240888335, 0.45, 0.098480775301221);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031594039095728, 8, 4 ), 
    document.ia.materials.m5b9999
);
o.position.set(0.38, 0.48, 2.9391523179536E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031435671987705, 8, 4 ), 
    document.ia.materials.m67725b
);
o.position.set(0.5, 0.405, 0.09);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031435671987705, 8, 4 ), 
    document.ia.materials.m060c0c
);
o.position.set(0.4875, 0.0375, 3.0616169978684E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031435671987705, 8, 4 ), 
    document.ia.materials.m030c0b
);
o.position.set(0.48276586432229, 0.0325, 0.0060776862183426);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031276503005527, 8, 4 ), 
    document.ia.materials.m2d4c47
);
o.position.set(0.44091153481927, 0.24, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.031116519843821, 8, 4 ), 
    document.ia.materials.m39725f
);
o.position.set(0.39428458016159, 0.3375, 0.076954532248276);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03095570987923, 8, 4 ), 
    document.ia.materials.mb7e5e5
);
o.position.set(0.41, 0.81, 2.2043642384652E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.03095570987923, 8, 4 ), 
    document.ia.materials.m723516
);
o.position.set(0.66914467174146, 0.27, 0.12312725159724);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030794060158791, 8, 4 ), 
    document.ia.materials.m593b35
);
o.position.set(0.56893654271085, 0.28, 0.02431074487337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030631557387757, 8, 4 ), 
    document.ia.materials.m50593e
);
o.position.set(0.50911652932751, 0.2975, 0.10340481406628);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030631557387757, 8, 4 ), 
    document.ia.materials.m051912
);
o.position.set(0.46241229516856, 0.06, 0.027361611466054);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030631557387757, 8, 4 ), 
    document.ia.materials.m476651
);
o.position.set(0.45403733341286, 0.34, 0.077134513162385);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030631557387757, 8, 4 ), 
    document.ia.materials.m7f3526
);
o.position.set(0.67234135677714, 0.325, 0.060776862183426);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030631557387757, 8, 4 ), 
    document.ia.materials.ma56342
);
o.position.set(0.68324006105325, 0.455, 0.13338785589701);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030468187916836, 8, 4 ), 
    document.ia.materials.m13261f
);
o.position.set(0.46476152672053, 0.1125, 0.025651510749425);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030468187916836, 8, 4 ), 
    document.ia.materials.m468c8c
);
o.position.set(0.3625, 0.4125, 3.3677786976552E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030303937728813, 8, 4 ), 
    document.ia.materials.m1e332c
);
o.position.set(0.46241229516856, 0.16, 0.027361611466054);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030303937728813, 8, 4 ), 
    document.ia.materials.m0f2626
);
o.position.set(0.455, 0.105, 1.1021821192326E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030303937728813, 8, 4 ), 
    document.ia.materials.m355953
);
o.position.set(0.43106345728915, 0.28, 0.02431074487337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.030303937728813, 8, 4 ), 
    document.ia.materials.mdaf2e6
);
o.position.set(0.45886379332024, 0.9025, 0.0475);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029972737208072, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029972737208072, 8, 4 ), 
    document.ia.materials.m476656
);
o.position.set(0.44803847577293, 0.34, 0.06);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029972737208072, 8, 4 ), 
    document.ia.materials.m7f553f
);
o.position.set(0.61746157759824, 0.375, 0.085505035831417);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029972737208072, 8, 4 ), 
    document.ia.materials.m828c70
);
o.position.set(0.50955064977168, 0.495, 0.10832885283134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029805756871456, 8, 4 ), 
    document.ia.materials.m072126
);
o.position.set(0.44091153481927, 0.09, -0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029805756871456, 8, 4 ), 
    document.ia.materials.m677250
);
o.position.set(0.51172125199252, 0.3825, 0.13294904665665);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029637835778216, 8, 4 ), 
    document.ia.materials.m4c9999
);
o.position.set(0.35, 0.45, 3.6739403974421E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029637835778216, 8, 4 ), 
    document.ia.materials.m72442d
);
o.position.set(0.6268585038061, 0.315, 0.092345438697931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029637835778216, 8, 4 ), 
    document.ia.materials.m1e3328
);
o.position.set(0.46535898384862, 0.16, 0.04);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029637835778216, 8, 4 ), 
    document.ia.materials.m190a07
);
o.position.set(0.53446827135543, 0.065, 0.012155372436685);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029468957846396, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029468957846396, 8, 4 ), 
    document.ia.materials.m050c0a
);
o.position.set(0.48590461068821, 0.035, 0.01026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029299106530556, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029299106530556, 8, 4 ), 
    document.ia.materials.m507267
);
o.position.set(0.43657074809695, 0.3825, 0.046172719348965);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029299106530556, 8, 4 ), 
    document.ia.materials.m190c0a
);
o.position.set(0.52954423259037, 0.07, 0.010418890660016);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029128264802851, 8, 4 ), 
    document.ia.materials.m3d665f
);
o.position.set(0.42121537975902, 0.32, 0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.029128264802851, 8, 4 ), 
    document.ia.materials.m354c41
);
o.position.set(0.4610288568297, 0.255, 0.045);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028783539467852, 8, 4 ), 
    document.ia.materials.m286666
);
o.position.set(0.38, 0.28, 2.9391523179536E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028783539467852, 8, 4 ), 
    document.ia.materials.m355947
);
o.position.set(0.43937822173509, 0.28, 0.07);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028609619208119, 8, 4 ), 
    document.ia.materials.m4b593e
);
o.position.set(0.5, 0.2975, 0.105);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028609619208119, 8, 4 ), 
    document.ia.materials.ma56e52
);
o.position.set(0.65270005087771, 0.4875, 0.11115654658084);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028434635186155, 8, 4 ), 
    document.ia.materials.m0f261a
);
o.position.set(0.4610288568297, 0.105, 0.045);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028258567640733, 8, 4 ), 
    document.ia.materials.m3f7f7f
);
o.position.set(0.375, 0.375, 3.0616169978684E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028258567640733, 8, 4 ), 
    document.ia.materials.m5b6651
);
o.position.set(0.5, 0.36, 0.08);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.028258567640733, 8, 4 ), 
    document.ia.materials.m261613
);
o.position.set(0.53693029073796, 0.1125, 0.01302361332502);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02808139619111, 8, 4 ), 
    document.ia.materials.m263f3b
);
o.position.set(0.45075961234939, 0.2, 0.017364817766693);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02808139619111, 8, 4 ), 
    document.ia.materials.m071619
);
o.position.set(0.46553172864457, 0.065, -0.012155372436685);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m063f36
);
o.position.set(0.38920912778613, 0.1375, 0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m388c8c
);
o.position.set(0.335, 0.385, 4.0413344371863E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m414c35
);
o.position.set(0.5, 0.255, 0.09);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m3e594b
);
o.position.set(0.45453366630132, 0.2975, 0.0525);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m6b725b
);
o.position.set(0.50781416799501, 0.405, 0.088632697771099);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027903099809488, 8, 4 ), 
    document.ia.materials.m193f3f
);
o.position.set(0.425, 0.175, 1.836970198721E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027723656791889, 8, 4 ), 
    document.ia.materials.m07261c
);
o.position.set(0.44361844275285, 0.09, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02754304472731, 8, 4 ), 
    document.ia.materials.m93997a
);
o.position.set(0.52052120859954, 0.54, 0.11276311449431);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02754304472731, 8, 4 ), 
    document.ia.materials.m286651
);
o.position.set(0.38723688550569, 0.28, 0.082084834398161);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02754304472731, 8, 4 ), 
    document.ia.materials.m143333
);
o.position.set(0.44, 0.14, 1.4695761589768E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02754304472731, 8, 4 ), 
    document.ia.materials.m4295a5
);
o.position.set(0.30796248816262, 0.455, -0.067722789290103);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02754304472731, 8, 4 ), 
    document.ia.materials.m0c1917
);
o.position.set(0.47537980617469, 0.075, 0.0086824088833465);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027361240465059, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027178220080111, 8, 4 ), 
    document.ia.materials.m264c39
);
o.position.set(0.43504809471617, 0.225, 0.075);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027178220080111, 8, 4 ), 
    document.ia.materials.m4c7f76
);
o.position.set(0.40151922469878, 0.4, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.027178220080111, 8, 4 ), 
    document.ia.materials.m0a1914
);
o.position.set(0.47180922137642, 0.07, 0.02052120859954);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.m1a5959
);
o.position.set(0.3775, 0.2275, 3.000384657911E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.m132623
);
o.position.set(0.46306970926204, 0.1125, 0.01302361332502);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.m47665b
);
o.position.set(0.44361844275285, 0.34, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.madd8d1
);
o.position.set(0.41629134099396, 0.765, 0.029520190203378);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.m7f3f33
);
o.position.set(0.64772116295183, 0.35, 0.052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026993958836361, 8, 4 ), 
    document.ia.materials.m797f59
);
o.position.set(0.52565151074943, 0.425, 0.14095389311789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026808431147595, 8, 4 ), 
    document.ia.materials.m4c190f
);
o.position.set(0.61817693036146, 0.18, 0.041675562640063);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026808431147595, 8, 4 ), 
    document.ia.materials.m355941
);
o.position.set(0.44637688898167, 0.28, 0.089990265356116);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026621610536019, 8, 4 ), 
    document.ia.materials.m051619
);
o.position.set(0.46060768987951, 0.06, -0.013891854213354);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02643346958815, 8, 4 ), 
    document.ia.materials.m666647
);
o.position.set(0.53, 0.34, 0.10392304845413);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02643346958815, 8, 4 ), 
    document.ia.materials.m13261c
);
o.position.set(0.46752404735808, 0.1125, 0.0375);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02643346958815, 8, 4 ), 
    document.ia.materials.m662f14
);
o.position.set(0.65035081932575, 0.24, 0.10944644586421);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m7b7f66
);
o.position.set(0.51710100716628, 0.45, 0.093969262078591);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m050a0c
);
o.position.set(0.48590461068821, 0.035, -0.01026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m164c4c
);
o.position.set(0.395, 0.195, 2.5717582782094E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m021915
);
o.position.set(0.45568365111445, 0.055, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m878c70
);
o.position.set(0.51881110788291, 0.495, 0.10336618828645);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026243979907854, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026053112066316, 8, 4 ), 
    document.ia.materials.m3e5950
);
o.position.set(0.45066613740874, 0.2975, 0.035912115049195);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026053112066316, 8, 4 ), 
    document.ia.materials.ma3ccc5
);
o.position.set(0.42121537975902, 0.72, 0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026053112066316, 8, 4 ), 
    document.ia.materials.m4c7f6e
);
o.position.set(0.40603073792141, 0.4, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.026053112066316, 8, 4 ), 
    document.ia.materials.m63725b
);
o.position.set(0.49218583200499, 0.405, 0.088632697771099);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025860835548686, 8, 4 ), 
    document.ia.materials.mf2f2da
);
o.position.set(0.52375, 0.9025, 0.082272413359522);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025860835548686, 8, 4 ), 
    document.ia.materials.m586651
);
o.position.set(0.49305407289332, 0.36, 0.078784620240977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025860835548686, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025667118697126, 8, 4 ), 
    document.ia.materials.m261913
);
o.position.set(0.53523847327947, 0.1125, 0.025651510749425);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025667118697126, 8, 4 ), 
    document.ia.materials.m662a1e
);
o.position.set(0.63787308542171, 0.26, 0.04862148974674);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025667118697126, 8, 4 ), 
    document.ia.materials.m2c3f36
);
o.position.set(0.46752404735808, 0.2125, 0.0375);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025667118697126, 8, 4 ), 
    document.ia.materials.m2d7272
);
o.position.set(0.365, 0.315, 3.3065463576979E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m7acccc
);
o.position.set(0.34, 0.64, 3.9188697572715E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m3f150c
);
o.position.set(0.59848077530122, 0.15, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m050c0b
);
o.position.set(0.48522788370482, 0.035, 0.0052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.mc3d8d5
);
o.position.set(0.45814567049698, 0.8075, 0.014760095101689);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m727f66
);
o.position.set(0.5, 0.45, 0.1);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025471928649958, 8, 4 ), 
    document.ia.materials.m2c5942
);
o.position.set(0.42422277716886, 0.2625, 0.0875);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m397272
);
o.position.set(0.3875, 0.3375, 2.7554552980815E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m030c08
);
o.position.set(0.48484455543377, 0.0325, 0.0175);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m3d4c35
);
o.position.set(0.49218583200499, 0.255, 0.088632697771099);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m597f72
);
o.position.set(0.42952305344106, 0.425, 0.05130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m032620
);
o.position.set(0.43352547667168, 0.0825, 0.023442503985036);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025275231276582, 8, 4 ), 
    document.ia.materials.m66361e
);
o.position.set(0.63155696691003, 0.26, 0.095765640131187);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025076991107804, 8, 4 ), 
    document.ia.materials.m7f7f59
);
o.position.set(0.5375, 0.425, 0.12990381056767);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025076991107804, 8, 4 ), 
    document.ia.materials.m47593e
);
o.position.set(0.49088347067249, 0.2975, 0.10340481406628);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025076991107804, 8, 4 ), 
    document.ia.materials.ma0a584
);
o.position.set(0.52223130931617, 0.585, 0.12216004070217);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025076991107804, 8, 4 ), 
    document.ia.materials.m05332b
);
o.position.set(0.4113673022289, 0.11, 0.031256671980048);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.025076991107804, 8, 4 ), 
    document.ia.materials.m1e261f
);
o.position.set(0.4903581858547, 0.135, 0.022981333293569);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m0a1911
);
o.position.set(0.47401923788647, 0.07, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m8c4a2a
);
o.position.set(0.68089082950129, 0.3575, 0.13167775518038);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m070c0b
);
o.position.set(0.49060307379214, 0.04, 0.0068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.mcee5e5
);
o.position.set(0.455, 0.855, 1.1021821192326E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m0c1915
);
o.position.set(0.47650768448035, 0.075, 0.017101007166283);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m59342c
);
o.position.set(0.58617067838857, 0.2625, 0.030388431091713);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02487717126116, 8, 4 ), 
    document.ia.materials.m143323
);
o.position.set(0.44803847577293, 0.14, 0.06);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024675733360799, 8, 4 ), 
    document.ia.materials.m354c3d
);
o.position.set(0.46552800005965, 0.255, 0.057850884871789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m7f554c
);
o.position.set(0.59848077530122, 0.4, 0.034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m724c39
);
o.position.set(0.60571541983841, 0.3375, 0.076954532248275);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m010c08
);
o.position.set(0.47885691603232, 0.0275, 0.015390906449655);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m354c44
);
o.position.set(0.45771383206463, 0.255, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m8c411c
);
o.position.set(0.7067323765729, 0.33, 0.15048886306329);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m050c08
);
o.position.set(0.48700961894323, 0.035, 0.015);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m2c3f39
);
o.position.set(0.46476152672053, 0.2125, 0.025651510749425);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024472637451436, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024267841905815, 8, 4 ), 
    document.ia.materials.m99664c
);
o.position.set(0.64095389311789, 0.45, 0.1026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024267841905815, 8, 4 ), 
    document.ia.materials.m1e4c4c
);
o.position.set(0.41, 0.21, 2.2043642384652E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024267841905815, 8, 4 ), 
    document.ia.materials.m330c05
);
o.position.set(0.5886326977711, 0.11, 0.031256671980047);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024061303325086, 8, 4 ), 
    document.ia.materials.m336666
);
o.position.set(0.4, 0.3, 2.4492935982947E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024061303325086, 8, 4 ), 
    document.ia.materials.m1e2426
);
o.position.set(0.48522788370482, 0.135, -0.0052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024061303325086, 8, 4 ), 
    document.ia.materials.m8eb2ac
);
o.position.set(0.43106345728915, 0.63, 0.02431074487337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.024061303325086, 8, 4 ), 
    document.ia.materials.m032626
);
o.position.set(0.4325, 0.0825, 1.6532731788489E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023852976431422, 8, 4 ), 
    document.ia.materials.m233328
);
o.position.set(0.47701866670643, 0.17, 0.038567256581192);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023852976431422, 8, 4 ), 
    document.ia.materials.m0b2126
);
o.position.set(0.44829759296686, 0.0975, -0.018233058655028);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023642813952111, 8, 4 ), 
    document.ia.materials.m0f4c4c
);
o.position.set(0.38, 0.18, 2.9391523179536E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023642813952111, 8, 4 ), 
    document.ia.materials.m424c2d
);
o.position.set(0.51041889066002, 0.24, 0.11817693036146);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m3d6651
);
o.position.set(0.43071796769724, 0.32, 0.08);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.ma5a584
);
o.position.set(0.5325, 0.585, 0.11258330249198);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m010a0c
);
o.position.set(0.47784182555723, 0.0275, -0.0078141679950119);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m8e997a
);
o.position.set(0.51041889066002, 0.54, 0.11817693036146);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m111916
);
o.position.set(0.48590461068821, 0.085, 0.01026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m7f7f66
);
o.position.set(0.525, 0.45, 0.086602540378444);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023430766494298, 8, 4 ), 
    document.ia.materials.m0c3f2e
);
o.position.set(0.40603073792141, 0.15, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023216782409423, 8, 4 ), 
    document.ia.materials.m85b5bf
);
o.position.set(0.38920912778613, 0.6375, -0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023216782409423, 8, 4 ), 
    document.ia.materials.m115959
);
o.position.set(0.36, 0.21, 3.4290110376126E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023000807646312, 8, 4 ), 
    document.ia.materials.m66280a
);
o.position.set(0.66914467174146, 0.22, 0.12312725159724);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023000807646312, 8, 4 ), 
    document.ia.materials.m8c4638
);
o.position.set(0.66249327924701, 0.385, 0.057303898630087);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023000807646312, 8, 4 ), 
    document.ia.materials.m33100a
);
o.position.set(0.57878462024098, 0.12, 0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023000807646312, 8, 4 ), 
    document.ia.materials.m2c3f33
);
o.position.set(0.47127333338304, 0.2125, 0.04820907072649);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.023000807646312, 8, 4 ), 
    document.ia.materials.m99bfb8
);
o.position.set(0.42613941852408, 0.675, 0.02604722665004);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022782785591732, 8, 4 ), 
    document.ia.materials.m1e331e
);
o.position.set(0.48, 0.16, 0.069282032302755);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022782785591732, 8, 4 ), 
    document.ia.materials.m663328
);
o.position.set(0.61817693036146, 0.28, 0.041675562640063);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022782785591732, 8, 4 ), 
    document.ia.materials.m47664c
);
o.position.set(0.46143274341881, 0.34, 0.091925333174277);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m0a1619
);
o.position.set(0.47045576740963, 0.07, -0.010418890660016);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m020c07
);
o.position.set(0.48267949192431, 0.03, 0.02);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m235959
);
o.position.set(0.395, 0.245, 2.5717582782094E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m0c1919
);
o.position.set(0.475, 0.075, 6.1232339957368E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m193f2c
);
o.position.set(0.43504809471617, 0.175, 0.075);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022562656897073, 8, 4 ), 
    document.ia.materials.m74a5a5
);
o.position.set(0.4025, 0.5525, 2.3880612583373E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022340359289662, 8, 4 ), 
    document.ia.materials.madd1d8
);
o.position.set(0.41629134099396, 0.765, -0.029520190203378);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022340359289662, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022340359289662, 8, 4 ), 
    document.ia.materials.mc1f2f2
);
o.position.set(0.405, 0.855, 2.32682891838E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.022340359289662, 8, 4 ), 
    document.ia.materials.m3d4c2d
);
o.position.set(0.5, 0.24, 0.12);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02211582736701, 8, 4 ), 
    document.ia.materials.m23332b
);
o.position.set(0.47401923788647, 0.17, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02211582736701, 8, 4 ), 
    document.ia.materials.m727f59
);
o.position.set(0.51302361332502, 0.425, 0.14772116295183);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02211582736701, 8, 4 ), 
    document.ia.materials.m053333
);
o.position.set(0.41, 0.11, 2.2043642384652E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02211582736701, 8, 4 ), 
    document.ia.materials.m597f79
);
o.position.set(0.42613941852408, 0.425, 0.02604722665004);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02211582736701, 8, 4 ), 
    document.ia.materials.m4d5935
);
o.position.set(0.51215537243669, 0.28, 0.13787308542171);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021888992372047, 8, 4 ), 
    document.ia.materials.m080c0b
);
o.position.set(0.49295230534411, 0.0425, 0.005130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021888992372047, 8, 4 ), 
    document.ia.materials.m628c85
);
o.position.set(0.41875336037649, 0.4675, 0.028651949315044);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021888992372047, 8, 4 ), 
    document.ia.materials.m7f5f3f
);
o.position.set(0.60825317547305, 0.375, 0.125);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021888992372047, 8, 4 ), 
    document.ia.materials.m16261e
);
o.position.set(0.47401923788647, 0.12, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m2c5959
);
o.position.set(0.4125, 0.2625, 2.1431318985079E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m190f0a
);
o.position.set(0.52819077862358, 0.07, 0.02052120859954);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m0c1913
);
o.position.set(0.47834936490539, 0.075, 0.025);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.md8caad
);
o.position.set(0.56511377766511, 0.765, 0.10927389364671);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m1e332f
);
o.position.set(0.46060768987951, 0.16, 0.013891854213354);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m84a5a0
);
o.position.set(0.43598749605421, 0.585, 0.022574263096701);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021659781947188, 8, 4 ), 
    document.ia.materials.m7f7959
);
o.position.set(0.54820907072649, 0.425, 0.11490666646785);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m4c332d
);
o.position.set(0.55908846518073, 0.24, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m726d50
);
o.position.set(0.54338816365384, 0.3825, 0.10341599982106);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m54593e
);
o.position.set(0.5179560575246, 0.2975, 0.09866772518252);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m071910
);
o.position.set(0.46968911086754, 0.065, 0.035);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m7f3b19
);
o.position.set(0.68793852415718, 0.3, 0.13680805733027);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.021428119864699, 8, 4 ), 
    document.ia.materials.m060c09
);
o.position.set(0.48917468245269, 0.0375, 0.0125);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02119392573055, 8, 4 ), 
    document.ia.materials.m263f2e
);
o.position.set(0.46169777784405, 0.2, 0.064278760968654);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02119392573055, 8, 4 ), 
    document.ia.materials.m566647
);
o.position.set(0.5, 0.34, 0.12);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02119392573055, 8, 4 ), 
    document.ia.materials.m628c7e
);
o.position.set(0.42247535878516, 0.4675, 0.056433323648735);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02095711465847, 8, 4 ), 
    document.ia.materials.m261c16
);
o.position.set(0.52819077862358, 0.12, 0.02052120859954);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02095711465847, 8, 4 ), 
    document.ia.materials.mf2f2f2
);
o.position.set(0.5, 0.95, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02095711465847, 8, 4 ), 
    document.ia.materials.m11594d
);
o.position.set(0.36212691457829, 0.21, 0.048621489746741);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02095711465847, 8, 4 ), 
    document.ia.materials.m030c09
);
o.position.set(0.48355537913625, 0.0325, 0.011970705016398);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.02095711465847, 8, 4 ), 
    document.ia.materials.m262626
);
o.position.set(0.5, 0.15, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020717596910463, 8, 4 ), 
    document.ia.materials.m1e3325
);
o.position.set(0.46935822227524, 0.16, 0.051423008774923);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020717596910463, 8, 4 ), 
    document.ia.materials.m8c6946
);
o.position.set(0.61907849302036, 0.4125, 0.1375);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020717596910463, 8, 4 ), 
    document.ia.materials.m50726d
);
o.position.set(0.43352547667168, 0.3825, 0.023442503985036);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m0b2618
);
o.position.set(0.45453366630132, 0.0975, 0.0525);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m858c62
);
o.position.set(0.52821666182437, 0.4675, 0.15504928242967);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m1a5944
);
o.position.set(0.38488765395373, 0.2275, 0.083794935114789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m4d5947
);
o.position.set(0.49392231378166, 0.315, 0.068936542710855);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m4c7f7f
);
o.position.set(0.4, 0.4, 2.4492935982947E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m6e725b
);
o.position.set(0.51539090644966, 0.405, 0.084572335870732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020475277499477, 8, 4 ), 
    document.ia.materials.m1e3321
);
o.position.set(0.47428849561254, 0.16, 0.061283555449518);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m190d07
);
o.position.set(0.53288924172751, 0.065, 0.023941410032797);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m333f2c
);
o.position.set(0.49348819333749, 0.2125, 0.073860581475916);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m5f6651
);
o.position.set(0.50694592710668, 0.36, 0.078784620240977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m7e8c70
);
o.position.set(0.5, 0.495, 0.11);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m7f664c
);
o.position.set(0.58660254037844, 0.4, 0.1);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m1e6666
);
o.position.set(0.36, 0.26, 3.4290110376126E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m3e5942
);
o.position.set(0.46625365049146, 0.2975, 0.080434666527493);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.020230055749226, 8, 4 ), 
    document.ia.materials.m020c09
);
o.position.set(0.48120614758428, 0.03, 0.013680805733027);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m667f72
);
o.position.set(0.45669872981078, 0.45, 0.05);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m548c8c
);
o.position.set(0.39, 0.44, 2.6942229581242E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m726344
);
o.position.set(0.56894399988071, 0.36, 0.11570176974358);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m260c07
);
o.position.set(0.55908846518073, 0.09, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m2e3f26
);
o.position.set(0.49131759111665, 0.2, 0.098480775301221);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m193333
);
o.position.set(0.45, 0.15, 1.2246467991474E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019981824805381, 8, 4 ), 
    document.ia.materials.m141917
);
o.position.set(0.49060307379214, 0.09, 0.0068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.mb7e5dd
);
o.position.set(0.4113673022289, 0.81, 0.031256671980048);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.m507261
);
o.position.set(0.44154328524455, 0.3825, 0.0675);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.m333f33
);
o.position.set(0.4875, 0.225, 0.043301270189222);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.m5b7263
);
o.position.set(0.46552800005965, 0.405, 0.057850884871789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019730471091414, 8, 4 ), 
    document.ia.materials.m8c7054
);
o.position.set(0.59526279441629, 0.44, 0.11);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m7a998e
);
o.position.set(0.44361844275285, 0.54, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m2c3f3c
);
o.position.set(0.46306970926204, 0.2125, 0.01302361332502);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m354c48
);
o.position.set(0.45568365111445, 0.255, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m074c4c
);
o.position.set(0.365, 0.165, 3.3065463576979E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m51665b
);
o.position.set(0.46535898384862, 0.36, 0.04);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m070b0c
);
o.position.set(0.49060307379214, 0.04, -0.0068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m1f3f3f
);
o.position.set(0.4375, 0.1875, 1.5308084989342E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m05190f
);
o.position.set(0.46535898384862, 0.06, 0.04);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019475873701205, 8, 4 ), 
    document.ia.materials.m19110c
);
o.position.set(0.52349231551965, 0.075, 0.017101007166283);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m264c4c
);
o.position.set(0.425, 0.225, 1.836970198721E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m23332d
);
o.position.set(0.47180922137642, 0.17, 0.02052120859954);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m516658
);
o.position.set(0.46935822227524, 0.36, 0.051423008774923);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m3f2213
);
o.position.set(0.58222310431877, 0.1625, 0.059853525081992);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m8eb2b2
);
o.position.set(0.43, 0.63, 1.7145055188063E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m4c3935
);
o.position.set(0.54431634888555, 0.255, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m1a2620
);
o.position.set(0.48051442841485, 0.1275, 0.0225);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m99997a
);
o.position.set(0.53, 0.54, 0.10392304845413);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m592f1a
);
o.position.set(0.61511234604627, 0.2275, 0.083794935114789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m141915
);
o.position.set(0.49357212390313, 0.09, 0.01532088886238);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m664433
);
o.position.set(0.59396926207859, 0.3, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.019217903719227, 8, 4 ), 
    document.ia.materials.m03090c
);
o.position.set(0.48355537913625, 0.0325, -0.011970705016398);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m332f2d
);
o.position.set(0.50939692620786, 0.19, 0.0068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m72725b
);
o.position.set(0.5225, 0.405, 0.077942286340599);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m3e5954
);
o.position.set(0.44829759296686, 0.2975, 0.018233058655028);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m708c82
);
o.position.set(0.44831690585678, 0.495, 0.037622215765824);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m74a59d
);
o.position.set(0.40398124408131, 0.5525, 0.033861394645051);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m26140b
);
o.position.set(0.54933386259126, 0.0975, 0.035912115049195);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m535935
);
o.position.set(0.5239414100328, 0.28, 0.13155696691003);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m02090c
);
o.position.set(0.48120614758428, 0.03, -0.013680805733027);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m283323
);
o.position.set(0.49479055466999, 0.17, 0.059088465180732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m47594a
);
o.position.set(0.47750243366097, 0.315, 0.053623111018328);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018956423457437, 8, 4 ), 
    document.ia.materials.m190805
);
o.position.set(0.53939231012049, 0.06, 0.013891854213354);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m0f1914
);
o.position.set(0.48267949192431, 0.08, 0.02);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m66663d
);
o.position.set(0.54, 0.32, 0.13856406460551);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m070b0c
);
o.position.set(0.49015192246988, 0.04, -0.0034729635533386);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m063f3f
);
o.position.set(0.3875, 0.1375, 2.7554552980815E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.mc1f2ea
);
o.position.set(0.40644326346384, 0.855, 0.032993153756717);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m666651
);
o.position.set(0.52, 0.36, 0.069282032302755);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.ma9f2f2
);
o.position.set(0.3575, 0.8075, 3.49024337757E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m476660
);
o.position.set(0.44091153481927, 0.34, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m132619
);
o.position.set(0.47127333338304, 0.1125, 0.04820907072649);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m72392d
);
o.position.set(0.63294904665665, 0.315, 0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.mf2eada
);
o.position.set(0.53638711104815, 0.9025, 0.061064822920221);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m021911
);
o.position.set(0.45771383206463, 0.055, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m333f26
);
o.position.set(0.5, 0.2, 0.1);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m162621
);
o.position.set(0.47180922137642, 0.12, 0.02052120859954);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m626651
);
o.position.set(0.51368080573303, 0.36, 0.075175409662873);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m99bfbf
);
o.position.set(0.425, 0.675, 1.836970198721E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018691285596069, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.me5d6b7
);
o.position.set(0.56894399988071, 0.81, 0.11570176974358);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m132626
);
o.position.set(0.4625, 0.1125, 9.1848509936051E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m394c35
);
o.position.set(0.48460909355034, 0.255, 0.084572335870732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m0f1916
);
o.position.set(0.48120614758428, 0.08, 0.013680805733027);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m337f7f
);
o.position.set(0.35, 0.35, 3.6739403974421E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m444c35
);
o.position.set(0.50781416799501, 0.255, 0.088632697771099);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m0f3321
);
o.position.set(0.43937822173509, 0.13, 0.07);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.mc3d8d8
);
o.position.set(0.4575, 0.8075, 1.0409497792753E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m447272
);
o.position.set(0.41, 0.36, 2.2043642384652E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m1a261e
);
o.position.set(0.48276400002982, 0.1275, 0.028925442435894);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m8eb2a6
);
o.position.set(0.43422151654499, 0.63, 0.047882820065594);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018422332213105, 8, 4 ), 
    document.ia.materials.m516651
);
o.position.set(0.48, 0.36, 0.069282032302755);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m726b44
);
o.position.set(0.55785088487179, 0.36, 0.13788799976142);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m595935
);
o.position.set(0.535, 0.28, 0.12124355652982);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m2f3f2c
);
o.position.set(0.48717424462529, 0.2125, 0.070476946558943);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m7cb2a9
);
o.position.set(0.39659518593372, 0.595, 0.036466117310055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.mf2eac1
);
o.position.set(0.56106482292022, 0.855, 0.14554844419261);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m074c41
);
o.position.set(0.36705095334335, 0.165, 0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m333333
);
o.position.set(0.5, 0.2, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m010c07
);
o.position.set(0.48051442841485, 0.0275, 0.0225);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.018149393684258, 8, 4 ), 
    document.ia.materials.m535947
);
o.position.set(0.50607768621834, 0.315, 0.068936542710855);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m6b9991
);
o.position.set(0.4113673022289, 0.51, 0.031256671980048);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m233323
);
o.position.set(0.485, 0.17, 0.051961524227066);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m0c0c08
);
o.position.set(0.50256515107494, 0.0425, 0.014095389311789);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m7e8c62
);
o.position.set(0.51432597465752, 0.4675, 0.16249327924701);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m993f2d
);
o.position.set(0.70680962813256, 0.39, 0.072932234620111);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m99705b
);
o.position.set(0.61276311449431, 0.48, 0.08208483439816);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m84a59a
);
o.position.set(0.43891997964892, 0.585, 0.044462618632337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m0c0605
);
o.position.set(0.51477211629518, 0.035, 0.0052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m7f6e4c
);
o.position.set(0.5766044443119, 0.4, 0.12855752193731);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m667f6e
);
o.position.set(0.46169777784405, 0.45, 0.064278760968654);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01787228743173, 8, 4 ), 
    document.ia.materials.m997a5b
);
o.position.set(0.60392304845413, 0.48, 0.12);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m032026
);
o.position.set(0.43352547667168, 0.0825, -0.023442503985036);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m5b725f
);
o.position.set(0.47107455756411, 0.405, 0.068943999880708);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m5f725b
);
o.position.set(0.48460909355034, 0.405, 0.084572335870732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m95a59a
);
o.position.set(0.47510355559863, 0.6175, 0.041781194629625);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m546651
);
o.position.set(0.48631919426697, 0.36, 0.075175409662873);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m6b9989
);
o.position.set(0.41542766412927, 0.51, 0.06156362579862);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m617250
);
o.position.set(0.5, 0.3825, 0.135);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m475947
);
o.position.set(0.4825, 0.315, 0.060621778264911);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017590816495505, 8, 4 ), 
    document.ia.materials.m3d9999
);
o.position.set(0.32, 0.42, 4.4087284769305E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m516647
);
o.position.set(0.48958110933998, 0.34, 0.11817693036146);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m133f29
);
o.position.set(0.42422277716886, 0.1625, 0.0875);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m25331e
);
o.position.set(0.49305407289332, 0.16, 0.078784620240977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m476647
);
o.position.set(0.47, 0.34, 0.10392304845413);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m47594d
);
o.position.set(0.47318844449084, 0.315, 0.044995132678058);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m424c3d
);
o.position.set(0.49479055466999, 0.27, 0.059088465180732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m4c2c26
);
o.position.set(0.57386058147592, 0.225, 0.02604722665004);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m070a0c
);
o.position.set(0.49133974596216, 0.04, -0.01);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m8c8c70
);
o.position.set(0.5275, 0.495, 0.095262794416288);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m111915
);
o.position.set(0.48700961894323, 0.085, 0.015);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.macbfb8
);
o.position.set(0.46476152672053, 0.7125, 0.025651510749425);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m05080c
);
o.position.set(0.48700961894323, 0.035, -0.015);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m260903
);
o.position.set(0.56647452332832, 0.0825, 0.023442503985036);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m667f77
);
o.position.set(0.4530153689607, 0.45, 0.034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m7f5933
);
o.position.set(0.62990381056767, 0.35, 0.15);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01730476789543, 8, 4 ), 
    document.ia.materials.m4c2816
);
o.position.set(0.59866772518252, 0.195, 0.07182423009839);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m262622
);
o.position.set(0.50375, 0.1425, 0.012990381056767);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m227272
);
o.position.set(0.3425, 0.2925, 3.8576374173142E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.mb7dde5
);
o.position.set(0.4113673022289, 0.81, -0.031256671980047);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m99916b
);
o.position.set(0.55785088487179, 0.51, 0.13788799976142);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m363f2c
);
o.position.set(0.5, 0.2125, 0.075);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m233326
);
o.position.set(0.4807163717094, 0.17, 0.045962666587139);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m4c1f16
);
o.position.set(0.60340481406628, 0.195, 0.036466117310055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m2c3f2f
);
o.position.set(0.47589546463675, 0.2125, 0.057453333233923);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m3f332c
);
o.position.set(0.53523847327947, 0.2125, 0.025651510749425);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m2f3328
);
o.position.set(0.50347296355334, 0.18, 0.039392310120488);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m33664c
);
o.position.set(0.41339745962156, 0.3, 0.1);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.017013910745355, 8, 4 ), 
    document.ia.materials.m663d28
);
o.position.set(0.61276311449431, 0.28, 0.08208483439816);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m111913
);
o.position.set(0.4903581858547, 0.085, 0.022981333293569);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m1a2622
);
o.position.set(0.47885691603232, 0.1275, 0.015390906449655);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m597f6c
);
o.position.set(0.43504809471617, 0.425, 0.075);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m354c35
);
o.position.set(0.4775, 0.255, 0.077942286340599);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.mb7ccc1
);
o.position.set(0.46535898384862, 0.76, 0.04);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m28332d
);
o.position.set(0.48267949192431, 0.18, 0.02);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m5b725b
);
o.position.set(0.4775, 0.405, 0.077942286340599);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m59593e
);
o.position.set(0.52625, 0.2975, 0.090932667397366);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.md8d1ad
);
o.position.set(0.55463694682336, 0.765, 0.13022755533023);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.01671799407187, 8, 4 ), 
    document.ia.materials.m99996b
);
o.position.set(0.545, 0.51, 0.1558845726812);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m59423e
);
o.position.set(0.55170240703314, 0.2975, 0.018233058655028);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m070c0c
);
o.position.set(0.49, 0.04, 2.4492935982947E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m162619
);
o.position.set(0.4807163717094, 0.12, 0.045962666587139);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m505947
);
o.position.set(0.5, 0.315, 0.07);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m16261c
);
o.position.set(0.47701866670643, 0.12, 0.038567256581192);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m263323
);
o.position.set(0.48973939570023, 0.17, 0.056381557247155);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m2d7267
);
o.position.set(0.36705095334335, 0.315, 0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m5f663d
);
o.position.set(0.52736161146605, 0.32, 0.15035081932575);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m8c8c62
);
o.position.set(0.54125, 0.4675, 0.14289419162443);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m484c35
);
o.position.set(0.51539090644966, 0.255, 0.084572335870732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m19130c
);
o.position.set(0.52165063509461, 0.075, 0.025);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m0f1917
);
o.position.set(0.48030384493976, 0.08, 0.0069459271066772);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m2c3f2c
);
o.position.set(0.48125, 0.2125, 0.064951905283833);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016416744279035, 8, 4 ), 
    document.ia.materials.m283328
);
o.position.set(0.49, 0.18, 0.034641016151378);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m99724c
);
o.position.set(0.62990381056767, 0.45, 0.15);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m0f2226
);
o.position.set(0.45568365111445, 0.105, -0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m3e593e
);
o.position.set(0.47375, 0.2975, 0.090932667397366);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m0f1919
);
o.position.set(0.48, 0.08, 4.8985871965894E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m666047
);
o.position.set(0.53856725658119, 0.34, 0.091925333174277);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m3f7f74
);
o.position.set(0.37689903087347, 0.375, 0.043412044416733);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m33150f
);
o.position.set(0.56893654271085, 0.13, 0.02431074487337);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m4c382d
);
o.position.set(0.55638155724715, 0.24, 0.04104241719908);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m133f22
);
o.position.set(0.43297111122709, 0.1625, 0.11248783169514);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m132613
);
o.position.set(0.48125, 0.1125, 0.064951905283833);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.mb2ac8e
);
o.position.set(0.54499513267806, 0.63, 0.10724622203666);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m91996b
);
o.position.set(0.53078181289931, 0.51, 0.16914467174146);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.016109862186233, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m7f7259
);
o.position.set(0.55745333323392, 0.425, 0.096418141452981);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m0a0c0b
);
o.position.set(0.49530153689607, 0.045, 0.0034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m162616
);
o.position.set(0.485, 0.12, 0.051961524227066);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m725639
);
o.position.set(0.59742785792575, 0.3375, 0.1125);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.mb27759
);
o.position.set(0.66444620863753, 0.525, 0.11970705016398);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.mbfbfac
);
o.position.set(0.51875, 0.7125, 0.064951905283833);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m1e665a
);
o.position.set(0.36212691457829, 0.26, 0.048621489746741);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m354c39
);
o.position.set(0.47107455756411, 0.255, 0.068943999880708);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m516654
);
o.position.set(0.47428849561254, 0.36, 0.061283555449518);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015797019547864, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m1e4c35
);
o.position.set(0.4220577136594, 0.21, 0.09);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m6b9999
);
o.position.set(0.41, 0.51, 2.2043642384652E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m548c82
);
o.position.set(0.39167114716866, 0.44, 0.038202599086725);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m6e7f66
);
o.position.set(0.49131759111665, 0.45, 0.098480775301221);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m1f261e
);
o.position.set(0.49486969785011, 0.135, 0.028190778623577);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m222426
);
o.position.set(0.49295230534411, 0.1425, -0.005130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m03261a
);
o.position.set(0.43657074809695, 0.0825, 0.046172719348965);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m444c3d
);
o.position.set(0.5, 0.27, 0.06);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m708c7e
);
o.position.set(0.45236860279186, 0.495, 0.055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.ma0b2a9
);
o.position.set(0.46968911086754, 0.665, 0.035);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m51665f
);
o.position.set(0.46241229516856, 0.36, 0.027361611466054);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m4c4c35
);
o.position.set(0.5225, 0.255, 0.077942286340599);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.ma0b2ac
);
o.position.set(0.46711075827249, 0.665, 0.023941410032797);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m3d6666
);
o.position.set(0.42, 0.32, 1.9594348786358E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m19120f
);
o.position.set(0.51879385241572, 0.08, 0.013680805733027);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m06363f
);
o.position.set(0.38920912778613, 0.1375, -0.039070839975059);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m393f2c
);
o.position.set(0.50651180666251, 0.2125, 0.073860581475916);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m021519
);
o.position.set(0.45568365111445, 0.055, -0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m9aa584
);
o.position.set(0.51128713154835, 0.585, 0.12802500789159);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m592911
);
o.position.set(0.63155696691003, 0.21, 0.095765640131187);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m222626
);
o.position.set(0.4925, 0.1425, 1.836970198721E-18);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015477854939615, 8, 4 ), 
    document.ia.materials.m162623
);
o.position.set(0.47045576740963, 0.12, 0.010418890660016);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.me5e5ce
);
o.position.set(0.5225, 0.855, 0.077942286340599);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m0c1911
);
o.position.set(0.48084888892203, 0.075, 0.032139380484327);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.mc3d8d1
);
o.position.set(0.4600630636166, 0.8075, 0.029071712182682);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m132616
);
o.position.set(0.47589546463675, 0.1125, 0.057453333233923);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m0c1719
);
o.position.set(0.47537980617469, 0.075, -0.0086824088833465);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m111819
);
o.position.set(0.48522788370482, 0.085, -0.0052094453300079);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m663d3d
);
o.position.set(0.58, 0.32, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m3d4c3d
);
o.position.set(0.485, 0.27, 0.051961524227066);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m070c0a
);
o.position.set(0.49133974596216, 0.04, 0.01);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m8c6654
);
o.position.set(0.60336618828645, 0.44, 0.075244431531647);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m3b3f33
);
o.position.set(0.50434120444167, 0.225, 0.04924038765061);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m0c0806
);
o.position.set(0.51174615775982, 0.0375, 0.0085505035831417);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m261e16
);
o.position.set(0.52598076211353, 0.12, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m373f26
);
o.position.set(0.50868240888335, 0.2, 0.098480775301221);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m50725b
);
o.position.set(0.44829200008947, 0.3825, 0.086776327307683);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m332219
);
o.position.set(0.5469846310393, 0.15, 0.034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m262422
);
o.position.set(0.50574533332339, 0.1425, 0.0096418141452981);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.me5ddb7
);
o.position.set(0.55785088487179, 0.81, 0.13788799976142);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m1e2623
);
o.position.set(0.48590461068821, 0.135, 0.01026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m193322
);
o.position.set(0.46169777784405, 0.15, 0.064278760968654);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m1f3f2a
);
o.position.set(0.45212222230506, 0.1875, 0.080348451210817);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.015151968864407, 8, 4 ), 
    document.ia.materials.m01080c
);
o.position.set(0.47885691603232, 0.0275, -0.015390906449655);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m060c0b
);
o.position.set(0.48768990308735, 0.0375, 0.0043412044416733);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.macb28e
);
o.position.set(0.5239414100328, 0.63, 0.13155696691003);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m28331e
);
o.position.set(0.5, 0.16, 0.08);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m5b7267
);
o.position.set(0.4610288568297, 0.405, 0.045);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m474c3d
);
o.position.set(0.50520944533001, 0.27, 0.059088465180732);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m44725b
);
o.position.set(0.4220577136594, 0.36, 0.09);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m4a5947
);
o.position.set(0.4880292949836, 0.315, 0.065778483455014);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m3d4c42
);
o.position.set(0.47701866670643, 0.27, 0.038567256581192);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m7ca9b2
);
o.position.set(0.39659518593372, 0.595, -0.036466117310055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.mc1eaf2
);
o.position.set(0.40644326346384, 0.855, -0.032993153756717);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m3c3f2c
);
o.position.set(0.51282575537471, 0.2125, 0.070476946558943);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.mcee5da
);
o.position.set(0.4610288568297, 0.855, 0.045);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m33251e
);
o.position.set(0.53758770483144, 0.16, 0.027361611466053);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.mb7ccc8
);
o.position.set(0.46060768987951, 0.76, 0.013891854213354);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m3f3533
);
o.position.set(0.52462019382531, 0.225, 0.0086824088833465);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.mb7ccc5
);
o.position.set(0.46241229516856, 0.76, 0.027361611466054);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m5b726e
);
o.position.set(0.45568365111445, 0.405, 0.015628335990024);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m475953
);
o.position.set(0.46711075827249, 0.315, 0.023941410032797);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014818917889108, 8, 4 ), 
    document.ia.materials.m725444
);
o.position.set(0.58457233587073, 0.36, 0.06156362579862);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m58663d
);
o.position.set(0.51389185421335, 0.32, 0.15756924048195);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m0f1912
);
o.position.set(0.48467911113762, 0.08, 0.025711504387462);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m565947
);
o.position.set(0.5119707050164, 0.315, 0.065778483455014);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m99896b
);
o.position.set(0.56894399988071, 0.51, 0.11570176974358);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.mf2e2c1
);
o.position.set(0.5727742220963, 0.855, 0.12212964584044);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m23593e
);
o.position.set(0.40906733260263, 0.245, 0.105);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m8c8562
);
o.position.set(0.55302997779914, 0.4675, 0.12639733311463);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.macbfb2
);
o.position.set(0.47127333338304, 0.7125, 0.04820907072649);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m331b0f
);
o.position.set(0.56577848345501, 0.13, 0.047882820065594);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m494c3d
);
o.position.set(0.51026060429977, 0.27, 0.056381557247155);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.me5e1ce
);
o.position.set(0.52892544243589, 0.855, 0.068943999880708);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m0a2c33
);
o.position.set(0.42121537975902, 0.12, -0.027783708426709);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m3f2e26
);
o.position.set(0.5469846310393, 0.2, 0.034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m84a595
);
o.position.set(0.44370834875401, 0.585, 0.065);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m725f39
);
o.position.set(0.58617999985088, 0.3375, 0.14462721217947);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m99bfb2
);
o.position.set(0.42952305344106, 0.675, 0.05130302149885);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m161918
);
o.position.set(0.49530153689607, 0.095, 0.0034202014332567);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m164c31
);
o.position.set(0.40906733260263, 0.195, 0.105);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m0f4c38
);
o.position.set(0.38723688550569, 0.18, 0.082084834398161);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m07414c
);
o.position.set(0.36705095334335, 0.165, -0.046885007970071);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014478207566557, 8, 4 ), 
    document.ia.materials.m727244
);
o.position.set(0.545, 0.36, 0.1558845726812);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m141916
);
o.position.set(0.49133974596216, 0.09, 0.01);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m858c7e
);
o.position.set(0.5, 0.5225, 0.055);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.macbfb5
);
o.position.set(0.46752404735808, 0.7125, 0.0375);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m7f5d4c
);
o.position.set(0.59396926207859, 0.4, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m89997a
);
o.position.set(0.5, 0.54, 0.12);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m42a5a5
);
o.position.set(0.305, 0.455, 4.7761225166747E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m8c7954
);
o.position.set(0.58426488874309, 0.44, 0.14141327413104);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m7f7b66
);
o.position.set(0.53213938048433, 0.45, 0.076604444311898);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m3f1d0c
);
o.position.set(0.59396926207859, 0.15, 0.068404028665134);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m708c87
);
o.position.set(0.44583557358433, 0.495, 0.019101299543362);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m7a9989
);
o.position.set(0.44803847577293, 0.54, 0.06);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m3d4c44
);
o.position.set(0.47401923788647, 0.27, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.mb2b28e
);
o.position.set(0.535, 0.63, 0.12124355652982);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.014129283820367, 8, 4 ), 
    document.ia.materials.m191411
);
o.position.set(0.51409538931179, 0.085, 0.01026060429977);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m333f39
);
o.position.set(0.47834936490539, 0.225, 0.025);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m19140f
);
o.position.set(0.51732050807569, 0.08, 0.02);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m8c7e62
);
o.position.set(0.56319866655732, 0.4675, 0.10605995559828);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m3f4c3d
);
o.position.set(0.48973939570023, 0.27, 0.056381557247155);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m628c8c
);
o.position.set(0.4175, 0.4675, 2.0206672185931E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m66583d
);
o.position.set(0.56128355544952, 0.32, 0.10284601754985);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m085959
);
o.position.set(0.3425, 0.1925, 3.8576374173142E-17);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m726750
);
o.position.set(0.55170799991053, 0.3825, 0.086776327307683);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m28332c
);
o.position.set(0.48467911113762, 0.18, 0.025711504387462);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m000000
);
o.position.set(0.5, 0, -0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m99321e
);
o.position.set(0.73635386072293, 0.36, 0.083351125280127);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m95a59d
);
o.position.set(0.47185417437701, 0.6175, 0.0325);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m474c2d
);
o.position.set(0.52052120859954, 0.24, 0.11276311449431);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.mccccb7
);
o.position.set(0.52, 0.76, 0.069282032302755);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m3f2a26
);
o.position.set(0.54924038765061, 0.2, 0.017364817766693);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m190e0c
);
o.position.set(0.52462019382531, 0.075, 0.0086824088833465);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m7a9993
);
o.position.set(0.44091153481927, 0.54, 0.020837781320032);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m664a3d
);
o.position.set(0.57517540966287, 0.32, 0.054723222932107);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m99826b
);
o.position.set(0.5779422863406, 0.51, 0.09);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m262626
);
o.position.set(0.5, 0.15, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m313328
);
o.position.set(0.50684040286651, 0.18, 0.037587704831436);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m5b726b
);
o.position.set(0.45771383206463, 0.405, 0.03078181289931);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.m899991
);
o.position.set(0.47401923788647, 0.57, 0.03);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013771522363655, 8, 4 ), 
    document.ia.materials.mf2f2f2
);
o.position.set(0.5, 0.95, 0);
scene.add(o);

o = new THREE.Mesh(
    new THREE.SphereGeometry( 0.013404215573797, 8, 4 ), 
    document.ia.materials.m59251a
);
o.position.set(0.620638949744, 0.2275, 0.042543803528398);
scene.add(o);



var render = function () { 
        requestAnimationFrame( render ); 
        // cube.rotation.x += 0.01 * Math.PI; 
        // cube.rotation.y += 0.005 * Math.PI;
        renderer.render(scene, camera); 
}; 
render(); 


