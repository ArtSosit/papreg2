<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>ปรับ REG </title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=K2D:wght@300;400;500;600;700&display=swap">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <script>
    window.onload = function() {
      fetchDataReasons(1);
      fetchDatapropos_issue(4);
      fetchDatamati(5);
      fetchDataTb1();
      fetchDataTb2();

    }

    function fetchDataReasons(formId) {
      console.log(formId)
      $.ajax({
        url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
        type: 'GET', // การส่งข้อมูลแบบ GET
        dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
        data: {
          action: 'getform', // ส่งค่า action ไปด้วย
          formId: formId // ส่ง formId ไปด้วย
        },
        success: function(data) {
          if (data.response === 'success') {

            const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
            console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
            const tbody = $('#fetchDataReasons'); // อ้างอิง <tbody>
            tbody.empty();
            if (Array.isArray(fetchedDataArray) && fetchedDataArray.length > 0) {
              fetchedDataArray.forEach((item) => {
                console.log("ข้อมูล:", item);
                const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editreasons" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
                tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
              });
            } else {
              tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
            }
          } else {
            console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
          }
        },
        error: function(xhr, status, error) {
          console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
        }
      });
    }

    function fetchDatapropos_issue(formId) {
      $.ajax({
        url: 'fetch_data.php',
        type: 'GET',
        dataType: 'json',
        data: {
          action: 'getAll',
          formId: formId ?? 4
        },
        success: function(data) {
          if (data.response === 'success') {
            const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
            console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);

            const tbody = $('#fetchDatapropos_issue'); // อ้างอิง <tbody>
            tbody.empty(); // ล้างข้อมูลเก่าใน <tbody>

            // ตรวจสอบว่า fetchedDataArray เป็น Array และมีข้อมูล
            if (Array.isArray(fetchedDataArray) && fetchedDataArray.length > 0) {
              fetchedDataArray.forEach((item) => {
                const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                  <button id="editpropos_issue" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
                tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
              });
            } else {
              tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
            }
          } else {
            console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);

          }
        },
        error: function(xhr, status, error) {
          console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
        }
      });
    }

    function fetchDatamati(formId) {
      $.ajax({
        url: 'fetch_data.php',
        type: 'GET',
        dataType: 'json',
        data: {
          action: 'getAll',
          formId: formId ?? 5
        },
        success: function(data) {
          if (data.response === 'success') {
            const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
            console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);

            const tbody = $('#fetchDatamati'); // อ้างอิง <tbody>
            tbody.empty(); // ล้างข้อมูลเก่าใน <tbody>

            // ตรวจสอบว่า fetchedDataArray เป็น Array และมีข้อมูล
            if (Array.isArray(fetchedDataArray) && fetchedDataArray.length > 0) {
              fetchedDataArray.forEach((item) => {
                console.log("ข้อมูล:", item);
                const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                  <button id="editmati"class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
                tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
              });
            } else {
              tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
            }
          } else {
            console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);

          }
        },
        error: function(xhr, status, error) {
          console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
        }
      });
    }
  </script>
  <script>
    function fetchDataTb1() {
      const action = "table1";

      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'fetchtable.php?action=' + action, true);

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            try {
              var tb1 = JSON.parse(xhr.responseText);
              displayDataTb1(tb1);
              console.log("tb1", tb1);
            } catch (e) {
              console.error('Error parsing JSON:', e);
            }
          } else {
            console.error('Failed to fetch data:', xhr.status);
          }
        }
      };

      xhr.send();
    }

    function displayDataTb1(tb1) {
      const tableBody = document.getElementById('displayDataTb1');
      if (!tableBody) {
        console.error("Element with ID 'displayDataTb1' not found in the DOM");
        return;
      }

      let output = '';

      // ตรวจสอบว่า `tb1.data` เป็น array และมีข้อมูล
      if (tb1.response === 'success' && Array.isArray(tb1.data) && tb1.data.length > 0) {
        // สร้างแถวในตารางสำหรับแต่ละข้อมูลใน `tb1.data`
        tb1.data.forEach((item, index) => {
          // console.log("item", item)
          output += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">${index+1}</td>
                        <td class="py-2 px-4">${item.origin_info ?? ''}</td>
                        <td class="py-2 px-4">${item.updated_info ??''}</td>
                        <td class="py-2 px-4">${item.improv_info ??''}</td>
                        <td class="py-2 px-4">
                            <button class="btn btn-warning" onclick="editAll1(${item.id})">แก้ไข</button>
                        </td>
                        <td class="py-2 px-4">
                            <button class="action-btn delete-btn btn btn-danger" onclick="ondeletetable(${item.id})">ลบ</button>
                        </td>
                    </tr>
                `;

        });
      } else {
        // ถ้าไม่มีข้อมูล
        output = `
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">ไม่พบข้อมูล</td>
            </tr>
        `;
      }

      // อัปเดตเนื้อหาของตาราง
      tableBody.innerHTML = output;
    }


    function sanitizeHTML(str) {
      const temp = document.createElement('div');
      temp.textContent = str;
      return temp.innerHTML;
    }
  </script>
  <script>
    function fetchDataTb2() {
      const action = "table2"
      console.log("table2")
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'fetchtable.php?action=' + action, true); // ใช้ URL ว่างเพื่อเรียกไฟล์เดียวกัน
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var tb2 = JSON.parse(xhr.responseText);
          displayDataTb2(tb2);
          console.log("tb2", tb2);

        }
      };

      xhr.send();
    }

    function displayDataTb2(tb2) {

      const tableBody = document.getElementById('displayDataTb2');
      if (!tableBody) {
        console.error("Element with ID 'displayDataTb2' not found in the DOM");
        return;
      }
      let output = '';
      if (tb2.response === 'success' && Array.isArray(tb2.data) && tb2.data.length > 0) {

        tb2.data.forEach((item, index) => {

          output += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">${item.list_subject ??''}</td>
                        <td colspan="5" class="py-2 px-4">${item.row2 ?? ''}</td>
                        <td colspan="4" class="py-2 px-4">${item.row3 ??''}</td>
                        <td colspan="3" class="py-2 px-4">${item.row4 ??''}</td>
                        <td colspan="3" class="py-2 px-4">${item.row5 ??''}</td>
                        <td colspan="4" class="py-2 px-4">${item.row6 ??''}</td>
                        <td class="py-2 px-4">
                            <button class="btn btn-warning" onclick="editAll1(${item.id})">แก้ไข</button>
                        </td>
                        <td class="py-2 px-4">
                            <button class="action-btn delete-btn btn btn-danger" onclick="ondeletetable2(${item.id})">ลบ</button>
                        </td>
                    </tr>
                `;

        });
      } else {
        // ถ้าไม่มีข้อมูล
        output = `
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">ไม่พบข้อมูล</td>
            </tr>
        `;
      }

      // อัปเดตเนื้อหาของตาราง
      tableBody.innerHTML = output;
    }

    function sanitizeHTML(str) {
      const temp = document.createElement('div');
      temp.textContent = str;
      return temp.innerHTML;
    }
  </script>
</head>

<body style=" font-family: 'K2D' , sans-serif ,hold-transition sidebar-mini">
  <!-- nav -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">ปรับตัว</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- nav offcanva -->

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav
    ">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- end nav -->
  <div class="container mt-5">
    <h1>ฟอร์มบันทึกข้อมูล</h1>
    <div class="card mt-5">
      <label class="card-header card-outline" for="origin_info">4.10</label>
      <div class="card-body bg-white shadow-md rounded-lg">
        <h5><b>4.10 การเพิ่มเติมรายวิชาในหมวดวิชาเฉพาะ และการเพิ่มเติมแผนที่แสดงการกระจาย
            ความรับผิดชอบมาตรฐานผลการเรียนรู้จากหลักสูตรสู่รายวิชา (Curriculum Mapping) ในหลักสูตรวิทยาศาสตรบัณฑิต สาขาวิชาชีววิทยา
            (หลักสูตรปรับปรุง พ.ศ. 2565) คณะวิทยาศาสตร์</b></h5>
      </div>
      <div class="card-footer">
      </div>
    </div>
    <!-- หลักการและเหตุผล -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header" for="reasons">เหตุผลในการปรับปรุงแก้ไข</label>
        <div class="card-body">
          <textarea id="reasons" class="form-control"></textarea>
          <button id="savereasons" data-form-id="1" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หัวข้อ</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataReasons">
            </tbody>
          </table>
        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>

    <!-- TABLE1 -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header">1. เพิ่มเติมรายวิชาใหม่ หมวดวิชาเฉพาะ</label>
        <div class="card-body">
          <!-- Textarea ทั้ง 3 ส่วน -->
          <div class="section">
            <label for="origin_info">ข้อมูลเดิม</label>
            <textarea id="origin_info" class="form-control mt-2"></textarea>
          </div>

          <div class="section mt-4">
            <label for="updated_info">ข้อมูลปรับปรุงใหม่</label>
            <textarea id="updated_info" class="form-control mt-2"></textarea>
          </div>

          <div class="section mt-4">
            <label for="improv_info">สาระการปรับปรุง</label>
            <textarea id="improv_info" class="form-control mt-2"></textarea>
          </div>

          <!-- ปุ่มบันทึก -->
          <button id="Allsave" class="btn btn-success mt-4">บันทึกทั้งหมด</button>
        </div>

        <!-- แสดงข้อมูลในตาราง -->
        <div class="card-body bg-white shadow-md rounded-lg mt-4">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th id="" class='py-2 px-4 border-b font-k2d'>ที่</th>
                <th class='py-2 px-4 border-b font-k2d'>ข้อมูลเดิม</th>
                <th class='py-2 px-4 border-b font-k2d'>ข้อมูลปรับปรุงใหม่</th>
                <th class='py-2 px-4 border-b font-k2d'>สาระการปรับปรุง</th>
                <th class='py-2 px-4 border-b font-k2d'>แก้ไข</th>
                <th class='py-2 px-4 border-b font-k2d'>ลบ</th>
              </tr>
            </thead>
            <tbody id="displayDataTb1">

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- TABLE2 -->
    <div class="card mt-5">
      <label class="card-header card-outline" for="origin_info">4.10</label>
      <div class="card-body bg-white shadow-md rounded-lg">
        <h5><b>

            4.10 การเพิ่มเติมรายวิชาในหมวดวิชาเฉพาะ และการเพิ่มเติมแผนที่แสดงการกระจาย
            ความรับผิดชอบมาตรฐานผลการเรียนรู้จากหลักสูตรสู่รายวิชา (Curriculum Mapping) ในหลักสูตรวิทยาศาสตรบัณฑิต สาขาวิชาชีววิทยา
            (หลักสูตรปรับปรุง พ.ศ. 2565) คณะวิทยาศาสตร์</b></h5>

        </b></h5>
      </div>
      <div class="card-footer">
      </div>
    </div>
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header">จัดการข้อมูล2</label>
        <div class="card-body">

          <!-- ข้อมูลเดิม2 -->
          <div class="section">
            <label for="list_subject">รายวิชา</label>
            <textarea id="list_subject" class="form-control mt-2"></textarea>
          </div>
          <!-- ข้อมูลปรับปรุงใหม่2 -->
          <div class="section mt-4 form-check">

            <label for="updated_info2">1. คุณธรรม จริยธรรม</label>
            <div>
              <input type="radio" id="rating1" name="ethics" value="1">
              <label for="rating1">1</label>
              <input type="radio" id="rating2" name="ethics" value="2">
              <label for="rating2">2</label>
              <input type="radio" id="rating3" name="ethics" value="3">
              <label for="rating3">3</label>
              <input type="radio" id="rating4" name="ethics" value="4">
              <label for="rating4">4</label>
              <input type="radio" id="rating5" name="ethics" value="5">
              <label for="rating5">5</label>
            </div>
          </div>
          <div class="section mt-4 form-check">
            <label for="improv_info1">2. ความรู้</label>
            <div>
              <input type="radio" id="knowledge1" name="knowledge" value="1">
              <label for="knowledge1">1</label>
              <input type="radio" id="knowledge2" name="knowledge" value="2">
              <label for="knowledge2">2</label>
              <input type="radio" id="knowledge3" name="knowledge" value="3">
              <label for="knowledge3">3</label>
              <input type="radio" id="knowledge4" name="knowledge" value="4">
              <label for="knowledge4">4</label>
            </div>
          </div>

          <div class="section mt-4 form-check">
            <label for="improv_info2">3. ทักษะทางปัญญา</label>
            <div>
              <input type="radio" id="cognitive1" name="cognitive" value="1">
              <label for="cognitive1">1</label>
              <input type="radio" id="cognitive2" name="cognitive" value="2">
              <label for="cognitive2">2</label>
              <input type="radio" id="cognitive3" name="cognitive" value="3">
              <label for="cognitive3">3</label>
            </div>
          </div>
          <div class="section mt-4 form-check">
            <label for="improv_info3">4. ทักษะความสัมพันธ์ระหว่างบุคคลและความรับผิดชอบ</label>
            <div>
              <input type="radio" id="relationship1" name="relationship" value="1">
              <label for="relationship1">1</label>
              <input type="radio" id="relationship2" name="relationship" value="2">
              <label for="relationship2">2</label>
              <input type="radio" id="relationship3" name="relationship" value="3">
              <label for="relationship3">3</label>
            </div>
          </div>

          <div class="section mt-4 form-check">
            <label for="improv_info4">5. ทักษะในการวิเคราะห์เชิงตัวเลข การสื่อสาร และการใช้เทคโนโลยีสารสนเทศ</label>
            <div>
              <input type="radio" id="analysis1" name="analysis" value="1">
              <label for="analysis1">1</label>
              <input type="radio" id="analysis2" name="analysis" value="2">
              <label for="analysis2">2</label>
              <input type="radio" id="analysis3" name="analysis" value="3">
              <label for="analysis3">3</label>
              <input type="radio" id="analysis4" name="analysis" value="4">
              <label for="analysis4">4</label>
            </div>
          </div>

          <div class="card-body bg-white shadow-md rounded-lg mt-4">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th rowspan="2" class='py-2 px-4 border-b font-k2d'>รายวิชา</th>
                  <th colspan="5" class='py-2 px-4 border-b font-k2d'>1.คุณธรรม จริยธรรม</th>
                  <th colspan="4" class='py-2 px-4 border-b font-k2d'>2.ความรู้</th>
                  <th colspan="3" class='py-2 px-4 border-b font-k2d'>3.ทักษะทางปัญญา</th>
                  <th colspan="3" class='py-2 px-4 border-b font-k2d'>4.ทักษะความสัมพันธ์ระหว่างบุคคลและความรับผิดชอบ</th>
                  <th colspan="4" class='py-2 px-4 border-b font-k2d'>5.ทักษะในการวิเคราะห์เชิงตัวเลข การสื่อสาร และการใช้เทคโนโลยีสารสนเทศ</th>
                  <th rowspan="2">แก้ไข</th>
                  <th rowspan="2">ลบ</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                </tr>
              </thead>
              <button id="Allsave2" class="btn btn-success mt-4">บันทึกทั้งหมด</button>
              <tbody id="displayDataTb2">

              </tbody>
            </table>
          </div>
        </div>
        <div class=" card-footer">
        </div>
      </div>
      </b></h5>
    </div>
    <div class="card mt-5">
      <div class="card-body bg-white shadow-md rounded-lg">
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;โครงสร้างหลักสูตร (จำนวนหน่วยกิตรวม จำนวนหน่วยกิตของรายวิชาหมวดต่างๆ) <b>ไม่มีการเปลี่ยนแปลง</b> ภายหลังการปรับปรุงแก้ไข</span></p>
        <p>เมื่อเปรียบเทียบกับโครงสร้างเดิม และเกณฑ์มาตรฐานหลักสูตรระดับอุดมศึกษา</p>
      </div>
      <div class="card-footer">
      </div>
    </div></b></h5>

    <!-- ประเด็นที่เสนอ -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header" for="propos_issue">ประเด็นที่เสนอ</label>
        <div class="card-body">
          <textarea id="propos_issue" class="form-control"></textarea>
          <button id="savepropos_issue" data-form-id="4" class="btn btn-success mt-2">บันทึก</button>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>หัวข้อ</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="fetchDatapropos_issue">
              </tbody>
            </table>
          </div>

        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>
    <!-- มติ -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header" for="mati">มติ</label>
        <div class="card-body">
          <textarea id="mati" class="form-control"></textarea>
          <button id="savemati" data-form-id="5" class="btn btn-success mt-2">บันทึก</button>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>หัวข้อ</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="fetchDatamati">
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>
    <script>
      $(function() {
        // Initialize all Summernote editors
        $('#reasons, #Improving_content, #origin_info, #updated_info, #improv_info, #list_subject, #updated_info2, #improv_info2, #propos_issue, #mati').summernote({
          height: 120,
        });

        // เพิ่ม
        $('#Allsave').on('click', function() {
          // const formId = $(this).data('form-id');
          const originInfo = $('#origin_info').val();
          const updatedInfo = $('#updated_info').val();
          const improvInfo = $('#improv_info').val();
          // console.log("id", formId);
          console.log("ข้อมูลที่ส่ง:", originInfo, updatedInfo, improvInfo);

          // ส่งข้อมูลทั้งหมดไปที่เซิร์ฟเวอร์ผ่าน AJAX
          $.ajax({
            url: 'insert.php', // ไฟล์ PHP สำหรับบันทึกข้อมูล
            type: 'POST',
            data: {
              // formId: formId,
              action: 'Allsave',
              origin_info: originInfo,
              updated_info: updatedInfo,
              improv_info: improvInfo
            },
            success: function(response) {
              try {
                const result = JSON.parse(response); // แปลง JSON string
                console.log("ผลลัพธ์จากเซิร์ฟเวอร์:", result);

                if (result.response === 'success') {
                  alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                  // อัปเดตข้อมูลในตาราง
                  $('#data-origin').text(originInfo);
                  $('#data-updated').text(updatedInfo);
                  $('#data-improv').text(improvInfo);

                  fetchDataTb1(); // โหลดข้อมูลใหม่
                } else {
                  alert(`เกิดข้อผิดพลาด: ${result.message || 'ไม่ทราบสาเหตุ'}`);
                  fetchDataTb1(); // โหลดข้อมูลใหม่
                }
              } catch (error) {
                console.error("เกิดข้อผิดพลาดในการแปลง JSON:", error);
                alert('ไม่สามารถประมวลผลการตอบสนองของเซิร์ฟเวอร์ได้');
                fetchDataTb1(); // โหลดข้อมูลใหม่
              }
            },
            error: function(xhr, status, error) {
              console.error("เกิดข้อผิดพลาด:", xhr, status, error);
              alert('เกิดข้อผิดพลาดในการส่งข้อมูล');
              fetchDataTb1(); // โหลดข้อมูลใหม่
            }
          });
        });


        // Handler for saving second set of fields
        $('#Allsave2').on('click', function() {
          const list_subject = $('#list_subject').val();
          const selectedethics = document.querySelector('input[name="ethics"]:checked')?.value;
          const selectedknowledge = document.querySelector('input[name="knowledge"]:checked')?.value;
          const selectedcognitive = document.querySelector('input[name="cognitive"]:checked')?.value;
          const selectedrelationship = document.querySelector('input[name="relationship"]:checked')?.value;
          const selectedanalysis = document.querySelector('input[name="analysis"]:checked')?.value;
          console.log(list_subject, selectedethics, selectedknowledge, selectedcognitive, selectedrelationship, selectedanalysis);

          // ส่งข้อมูลทั้งหมดไปที่เซิร์ฟเวอร์ผ่าน AJAX
          $.ajax({
            url: 'insert.php', // ไฟล์ PHP สำหรับบันทึกข้อมูล
            type: 'POST',
            data: {
              action: 'Allsave2',
              list_subject: list_subject,
              selectedethics: selectedethics,
              selectedknowledge: selectedknowledge,
              selectedcognitive: selectedcognitive,
              selectedrelationship: selectedrelationship,
              selectedanalysis: selectedanalysis
            },
            success: function(response) {
              const result = JSON.parse(response);
              if (result.response === '') {
                alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                windlow.location.reload();
                // อัปเดตข้อมูลในตาราง
                $('#data-origin2').text(originInfo);
                $('#data-updated2').text(updatedInfo);
                $('#data-improv2').text(improvInfo);

                fetchDataTb2()
                // location.reload();
              } else {

                alert('เกิดข้อผิดพลาดในการบันทึก');
                fetchDataTb2()


              }
            },
            error: function() {
              alert('เกิดข้อผิดพลาดในการส่งข้อมูล');
              fetchDataTb2();
              location.reload();
            }
          });
        });

      });

      function saveData(selector, formId) {
        var data = $(selector).summernote('code'); // Get the content
        console.log(data);

        // Check if content is empty or not
        if (data.trim() === "" || data.trim() === "<p><br></p>") {
          alert('เนื้อหาว่างเปล่า กรุณาเพิ่มข้อมูลก่อนบันทึก.');
          return; // Exit the function if content is empty
        }

        var encodedData = btoa(unescape(encodeURIComponent(data))); // Encode in Base64
        console.log(encodedData);
        console.log(formId)
        // AJAX request to save the data
        $.ajax({
          type: 'POST',
          url: 'insert.php',
          data: {
            action: 'saveform',
            data: encodedData,
            formId: formId // Send form ID to identify which form is being saved
          },
          success: function(response) {
            alert("บันทึกข้อมูลแล้ว"); // Handle success response
            console.log(response)
            if (formId == 1) {
              fetchDataReasons(formId);
            } else if (formId == 3) {
              fetchDatapropos_issue(formId);
            } else if (formId == 4) {
              fetchDatamati(formId);
            }

          },
          error: function(xhr, status, error) {
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล.');
          }
        });
      }
      // Attach click event handlers dynamically to buttons
      $('[id^="save"]').click(function() {
        var formId = $(this).data('form-id'); // Get form ID from the button's data attribute
        var relatedInputId = $(this).attr('id').replace('save', ''); // Extract the related input ID
        var selector = '#' + relatedInputId; // Create the selector dynamically

        saveData(selector, formId); // Call the save function with dynamic selector and form ID
      });
      // แก้ไข
      function editAll1(id) {
        console.log("editAll1");
        $.ajax({
          url: 'edit.php', // เปลี่ยนเป็นชื่อไฟล์ PHP ของคุณ
          type: 'POST',
          data: {
            action: 'getAll',
            id: id
          },
          success: function(response) {
            // Directly use the response object (no need for JSON.parse)
            if (response && response.response === 'success') {

              const dataItem = response.data[0];
              console.log("res", response)
              const {
                origin_info,
                updated_info,
                improv_info
              } = dataItem;

              console.log("log", response);
              // กำหนดค่าที่ดึงมาใส่ใน Summernote
              $('#origin_info').summernote('code', origin_info || '');
              $('#updated_info').summernote('code', updated_info || '');
              $('#improv_info').summernote('code', improv_info || '');
            } else {
              console.error('No data found or invalid response:', response);
            }
          },
          error: function(xhr, status, error) {
            // This will handle network or HTTP status errors (not related to JSON parsing)
            console.error('Error:', error);
            console.error('Response text:', xhr.responseText); // Log the raw response text from the server
          },
        });
      };


      function editAll2(id) {
        console.log('editAll2');
        $.ajax({
          url: 'edit.php', // เปลี่ยนเป็นชื่อไฟล์ PHP ของคุณ
          type: 'POST',
          data: {
            action: 'getAll2',
            id: id,
          },
          success: function(response) {
            // ตรวจสอบ response ว่า success หรือไม่
            console.log("edit", response)
            if (response && response.response === 'success') {
              $('#list_subject').summernote('code', response.data[6] || '');
            } else {
              console.error('No data found or invalid response:', response);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          },
        });
      };

      $(document).on('click', '.edit-btn', function() {
        const Id = $(this).attr('id').replace('edit', '');
        console.log("Editor ID:", Id);

        const formId = $(this).data('form-id'); // Get form ID from the button
        console.log("Form ID:", formId);

        // Fetch data for the given form ID
        $.ajax({
          url: 'fetch_data.php', // Endpoint for fetching data
          type: 'GET',
          data: {
            formId: formId,
            action: 'getform' // Specify the action
          },
          success: function(response) {
            console.log("Raw response:", response); // Debug raw response
            try {
              const result = JSON.parse(response);
              console.log("Parsed result:", result); // Debug parsed result
              if (result.response === 'success') {
                console.log(result)
                $('#' + Id).summernote('code', result.data[0].texts);
              } else {
                alert(result.message || 'ไม่พบข้อมูลหรือเกิดข้อผิดพลาด');
              }
            } catch (e) {
              console.error("JSON parse error:", e.message);
              alert('Error parsing response. Please check the console for details.');
            }
          },
          error: function(xhr, status, error) {
            console.error("Error details:", {
              xhr,
              status,
              error
            });
            alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
          }
        });
      });


      function ondeletetable(formId) {
        console.log("Form ID for deletion:", formId);
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
          $.ajax({
            type: 'POST',
            url: 'delete.php',
            data: {
              action: 'deletetable',
              formId: formId // Send the specific form ID
            },
            success: function(response) {
              console.log("Raw response:", Response); // Debug raw response
              try {
                const result = JSON.parse(response);
                console.log("Parsed result:", result); // Debug parsed result
                if (result.response === 'success') {
                  alert("ลบข้อมูลแล้ว");
                  location.reload()

                } else {
                  alert(result.message || 'เกิดข้อผิดพลาดในการลบข้อมูล');
                }
              } catch (e) {
                console.error("JSON parse error:", e.message);
                alert('Error parsing response. Please check the console for details.');
              }
            },
            error: function(xhr, status, error) {
              console.error("Error details:", {
                xhr,
                status,
                error
              });
              alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
            }
          });
        }

      };

      function ondeletetable2(formId) {
        console.log("Form ID for deletion:", formId);
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
          $.ajax({
            type: 'POST',
            url: 'delete.php',
            data: {
              action: 'deletetable2',
              formId: formId // Send the specific form ID
            },
            success: function(response) {
              console.log("Raw response:", response); // Debug raw response
              try {
                const result = JSON.parse(response);
                console.log("Parsed result:", result); // Debug parsed result
                if (result.response === 'success') {
                  alert("ลบข้อมูลแล้ว");
                  location.reload()

                } else {
                  alert(result.message || 'เกิดข้อผิดพลาดในการลบข้อมูล');
                }
              } catch (e) {
                console.error("JSON parse error:", e.message);
                alert('Error parsing response. Please check the console for details.');
              }
            },
            error: function(xhr, status, error) {
              console.error("Error details:", {
                xhr,
                status,
                error
              });
              alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
            }
          });
        }

      };

      function ondelete(formId) {
        // const formId = $(this).siblings('.edit-btn').data('form-id'); // Get form ID from the sibling edit button's data attribute
        console.log("Form ID for deletion:", formId);
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
          $.ajax({
            type: 'POST',
            url: 'delete.php',
            data: {
              action: 'deleteform',
              formId: formId // Send the specific form ID
            },
            success: function(response) {
              console.log("Raw response:", response); // Debug raw response
              try {
                const result = JSON.parse(response);
                console.log("Parsed result:", result); // Debug parsed result
                if (result.response === 'success') {
                  alert("ลบข้อมูลแล้ว");
                  location.reload()

                } else {
                  alert(result.message || 'เกิดข้อผิดพลาดในการลบข้อมูล');
                }
              } catch (e) {
                console.error("JSON parse error:", e.message);
                alert('Error parsing response. Please check the console for details.');
              }
            },
            error: function(xhr, status, error) {
              console.error("Error details:", {
                xhr,
                status,
                error
              });
              alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
            }
          });
        }

      };
    </script>
</body>

</html>