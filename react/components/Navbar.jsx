class Navbar extends React.Component {
  render() {
    const { logo } = path
    const { home, IS } = path.csmju
    return (
      <div className="navbar">
        <a href={home}>
          <img src={logo} />
        </a>
        <a href={IS}>หน้าหลักระบบสารสนเทศ</a>
      </div>
    );
  }
}
