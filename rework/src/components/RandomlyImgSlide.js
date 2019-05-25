class RandomlyImgSlide extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      img: 'index.png'
    };

    setInterval(this.callAjax, 2500);
  }

  ajaxCallback = (result) => {
    this.setState({
      img: result[0].img_path
    })
  }

  callAjax = () => {
    this.ajax(this.ajaxCallback)
  }

  ajax = (callback) => {
    $.ajax({
      type: "GET",
      url: "src/php/getAllActivities.php",
      dataType: "json",
      success: (result) => {
        callback(result)
      }
    });
  }

  render() {
    return <div className='random-img-slide'>
      <img src={`../beta/img/${this.state.img}`}></img>
    </div>;
  }
}
