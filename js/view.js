// Parameters.
var view_id = '_DEFAULT_';
var view_resolution = '1024x1024';

// Internals.
var _view_camera;
var _view_controls;
var _view_renderer;
var _view_scene;


function view_Init()
{
    var container = document.getElementById('container');

    _view_renderer = new THREE.WebGLRenderer();
    _view_renderer.setPixelRatio(window.devicePixelRatio);
    _view_renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(_view_renderer.domElement);

    _view_scene = new THREE.Scene();

    _view_camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 100);
    _view_camera.position.z = 0.01;

    _view_controls = new THREE.OrbitControls(_view_camera);
    _view_controls.enableZoom = false;
    _view_controls.enablePan = false;
    
    var loader = new THREE.TextureLoader();

    var texUrlBase = 'tex.php?id=' + view_id + '&r=' + view_resolution + '&f=';

    var materials =
    [
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'px'), overdraw: 0.5, side: THREE.FrontSide }), // right
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'nx'), overdraw: 0.5, side: THREE.FrontSide }), // left
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'py'), overdraw: 0.5, side: THREE.FrontSide }), // top
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'ny'), overdraw: 0.5, side: THREE.FrontSide }), // bottom
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'pz'), overdraw: 0.5, side: THREE.FrontSide }), // back
        new THREE.MeshBasicMaterial({ map: loader.load(texUrlBase + 'nz'), overdraw: 0.5, side: THREE.FrontSide })  // front
    ];

    var skyBox = new THREE.Mesh(new THREE.CubeGeometry(1, 1, 1), materials);
    skyBox.geometry.scale(1, 1, -1);
    _view_scene.add(skyBox);

    window.addEventListener('resize', view_OnWindowResize, false);
}


function view_OnWindowResize()
{
    _view_camera.aspect = window.innerWidth / window.innerHeight;
    _view_camera.updateProjectionMatrix();

    _view_renderer.setSize(window.innerWidth, window.innerHeight);
}


function view_Animate()
{
    _view_controls.update();  // Required by controls.enableDamping (if used).
    _view_renderer.render(_view_scene, _view_camera);

    requestAnimationFrame(view_Animate);
}