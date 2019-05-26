class Menu extends React.Component {
  render() {
    return (
      <div className='menu-user'>
        <div>Menu user</div>
        <a href="index.php">
          <RightArrow /> 
          <Text text="หน้าแรก" />
        </a>
        <a href="about.php">
          <RightArrow /> 
          <Text text="เกี่ยวกับชมรม" />
        </a>
        <a href="member.php">
          <RightArrow /> 
          <Text text="ทำเนียบชมรม" />
        </a>
        <a href="activity.php">
          <RightArrow /> 
          <Text text="โครงการและกิจกรรม" />
        </a>
        <a href="admin.php">
          <RightArrow /> 
          <Text text="การจัดการชมรม" />
        </a>
      </div>
    );
  }
}
